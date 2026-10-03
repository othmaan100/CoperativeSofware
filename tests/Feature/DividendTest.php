<?php

namespace Tests\Feature;

use App\Livewire\Chairman\DividendDeclarations;
use App\Livewire\Members\MyDividends;
use App\Livewire\Reports\DividendReports;
use App\Livewire\Treasurer\DividendPeriods;
use App\Models\ApplicationFeePayment;
use App\Models\DividendAllocation;
use App\Models\DividendPeriod;
use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\Member;
use App\Models\SavingsAccount;
use App\Models\SavingsProduct;
use App\Models\ShareAccount;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\LoanSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SavingsSeeder;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\ShareSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DividendTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
        $this->seed(SavingsSeeder::class);
        $this->seed(ShareSeeder::class);
        $this->seed(LoanSeeder::class);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    protected function makeActiveMember(array $overrides = []): Member
    {
        $user = User::factory()->create();
        $user->assignRole('member');

        return Member::factory()->create(array_merge([
            'user_id' => $user->id,
            'status' => 'active',
        ], $overrides));
    }

    protected function makeUserWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    public function test_time_weighted_average_balance_is_computed_correctly_from_the_ledger(): void
    {
        $member = $this->makeActiveMember();
        $account = ShareAccount::openFor($member);

        Carbon::setTestNow('2025-01-01 00:00:00');
        $account->recordTransaction(
            type: ShareAccount::TYPE_PURCHASE,
            shares: 10,
            unitPrice: 1000,
            description: 'First purchase',
            postedBy: null,
        );

        Carbon::setTestNow('2025-01-06 00:00:00');
        $account->recordTransaction(
            type: ShareAccount::TYPE_PURCHASE,
            shares: 10,
            unitPrice: 1000,
            description: 'Second purchase',
            postedBy: null,
        );

        Carbon::setTestNow();

        $average = $account->fresh()->averageBalanceBetween(
            Carbon::parse('2025-01-01 00:00:00'),
            Carbon::parse('2025-01-11 00:00:00'),
        );

        // ₦10,000 for the first 5 days, ₦20,000 for the next 5 days.
        $this->assertEquals(15000.0, $average);
    }

    public function test_distributable_profit_sums_loan_and_registration_profit_within_range_only(): void
    {
        $product = LoanProduct::query()->where('code', LoanProduct::REGULAR)->firstOrFail();
        $member = $this->makeActiveMember();

        Loan::create([
            'member_id' => $member->id,
            'loan_product_id' => $product->id,
            'loan_no' => 'LN-IN-RANGE',
            'principal_amount' => 100000,
            'interest_admin_pct' => 2,
            'interest_profit_pct' => 8,
            'total_interest' => 10000,
            'interest_admin_amount' => 2000,
            'interest_profit_amount' => 8000,
            'total_repayable' => 110000,
            'tenure_months' => 12,
            'monthly_installment' => 9166.67,
            'outstanding_balance' => 110000,
            'status' => 'disbursed',
            'disbursed_at' => '2025-03-15',
        ]);

        Loan::create([
            'member_id' => $member->id,
            'loan_product_id' => $product->id,
            'loan_no' => 'LN-OUT-OF-RANGE',
            'principal_amount' => 100000,
            'interest_admin_pct' => 2,
            'interest_profit_pct' => 8,
            'total_interest' => 10000,
            'interest_admin_amount' => 2000,
            'interest_profit_amount' => 8000,
            'total_repayable' => 110000,
            'tenure_months' => 12,
            'monthly_installment' => 9166.67,
            'outstanding_balance' => 110000,
            'status' => 'disbursed',
            'disbursed_at' => '2026-06-01',
        ]);

        $recorder = $this->makeUserWithRole('treasurer');
        ApplicationFeePayment::recordManual($member, 5000, $recorder->id, 'in range');
        ApplicationFeePayment::query()->latest('id')->first()->update(['paid_at' => '2025-05-01']);

        $profit = DividendPeriod::distributableProfitFor(Carbon::parse('2025-01-01'), Carbon::parse('2025-12-31'));

        // 8000 (in-range loan profit) + 80% of 5000 (registration fee profit) = 12000.
        $this->assertEquals(12000.0, $profit);
    }

    public function test_full_dividend_period_lifecycle_credits_savings_and_locks_the_period(): void
    {
        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');
        $member = $this->makeActiveMember();

        $shareAccount = ShareAccount::openFor($member);
        Carbon::setTestNow('2025-01-01 00:00:00');
        $shareAccount->recordTransaction(
            type: ShareAccount::TYPE_PURCHASE,
            shares: 10,
            unitPrice: 1000,
            description: 'Opening shares',
            postedBy: null,
        );

        $regularProduct = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->firstOrFail();
        $savingsAccount = SavingsAccount::openFor($member, $regularProduct);
        $savingsAccount->recordTransaction(
            type: 'voluntary_deposit',
            amount: 20000,
            description: 'Opening savings',
            postedBy: null,
        );
        Carbon::setTestNow();

        // 1. Treasurer opens a period.
        Livewire::actingAs($treasurer)
            ->test(DividendPeriods::class)
            ->call('openCreateForm')
            ->set('label', 'FY 2025')
            ->set('fy_start_date', '2025-01-01')
            ->set('fy_end_date', '2025-12-31')
            ->call('createPeriod');

        $period = DividendPeriod::firstOrFail();
        $this->assertSame(DividendPeriod::STATUS_OPEN, $period->status);

        // 2. Chairman declares rates.
        Livewire::actingAs($chairman)
            ->test(DividendDeclarations::class)
            ->call('openDeclareForm', $period->id)
            ->set('share_dividend_rate_pct', '10')
            ->set('savings_interest_rate_pct', '5')
            ->call('saveDeclare');

        $period->refresh();
        $this->assertSame(DividendPeriod::STATUS_DECLARED, $period->status);
        $this->assertEquals(10, (float) $period->share_dividend_rate_pct);

        // A treasurer must not be able to declare rates.
        try {
            Livewire::actingAs($treasurer)->test(DividendDeclarations::class);
            $this->fail('Expected the Treasurer to be blocked from Dividend Declarations.');
        } catch (\Throwable $e) {
            // Expected.
        }

        // 3. Treasurer calculates.
        Livewire::actingAs($treasurer)
            ->test(DividendPeriods::class)
            ->call('calculate', $period->id);

        $period->refresh();
        $this->assertSame(DividendPeriod::STATUS_CALCULATED, $period->status);

        $allocation = DividendAllocation::where('dividend_period_id', $period->id)->where('member_id', $member->id)->firstOrFail();
        $this->assertEquals(10000.0, (float) $allocation->average_share_balance);
        $this->assertEquals(1000.0, (float) $allocation->share_dividend_amount);
        $this->assertEquals(20000.0, (float) $allocation->average_savings_balance);
        $this->assertEquals(1000.0, (float) $allocation->savings_interest_amount);
        $this->assertSame('calculated', $allocation->status);

        // 4. Treasurer posts.
        Livewire::actingAs($treasurer)
            ->test(DividendPeriods::class)
            ->call('post', $period->id);

        $period->refresh();
        $allocation->refresh();
        $savingsAccount->refresh();

        $this->assertSame(DividendPeriod::STATUS_POSTED, $period->status);
        $this->assertSame('posted', $allocation->status);
        $this->assertNotNull($allocation->dividend_transaction_id);
        $this->assertNotNull($allocation->interest_transaction_id);
        $this->assertEquals(22000.0, (float) $savingsAccount->balance, 'Original 20,000 + 1,000 dividend + 1,000 interest.');

        $dividendTxn = $allocation->dividendTransaction;
        $interestTxn = $allocation->interestTransaction;
        $this->assertSame('dividend_credit', $dividendTxn->type);
        $this->assertSame('interest_credit', $interestTxn->type);

        // A posted period cannot be calculated or posted again.
        try {
            $period->calculate($treasurer->id);
            $this->fail('Expected calculate() to be blocked on a posted period.');
        } catch (\Throwable $e) {
            // Expected.
        }

        try {
            $period->post($treasurer->id);
            $this->fail('Expected post() to be blocked on an already-posted period.');
        } catch (\Throwable $e) {
            // Expected.
        }

        // 5. Member sees it on My Dividends.
        Livewire::actingAs($member->user)
            ->test(MyDividends::class)
            ->assertSee('FY 2025')
            ->assertSee('1,000.00');

        // 6. Reports show it too.
        Livewire::actingAs($treasurer)
            ->test(DividendReports::class)
            ->assertSee('FY 2025');
    }

    public function test_recalculating_a_declared_period_replaces_previous_allocations(): void
    {
        $treasurer = $this->makeUserWithRole('treasurer');
        $member = $this->makeActiveMember();

        $shareAccount = ShareAccount::openFor($member);
        Carbon::setTestNow('2025-01-01 00:00:00');
        $shareAccount->recordTransaction(
            type: ShareAccount::TYPE_PURCHASE,
            shares: 10,
            unitPrice: 1000,
            description: 'Opening shares',
            postedBy: null,
        );
        Carbon::setTestNow();

        $period = DividendPeriod::create([
            'label' => 'FY 2025',
            'fy_start_date' => '2025-01-01',
            'fy_end_date' => '2025-12-31',
            'status' => DividendPeriod::STATUS_DECLARED,
            'share_dividend_rate_pct' => 10,
            'savings_interest_rate_pct' => 5,
            'opened_by' => $treasurer->id,
        ]);

        $period->calculate($treasurer->id);
        $this->assertSame(1, DividendAllocation::where('dividend_period_id', $period->id)->count());

        // Buy more shares, then recalculate — should replace, not duplicate.
        Carbon::setTestNow('2025-06-01 00:00:00');
        $shareAccount->recordTransaction(
            type: ShareAccount::TYPE_PURCHASE,
            shares: 10,
            unitPrice: 1000,
            description: 'More shares',
            postedBy: null,
        );
        Carbon::setTestNow();

        $period->refresh();
        $period->calculate($treasurer->id);

        $this->assertSame(1, DividendAllocation::where('dividend_period_id', $period->id)->count(), 'Recalculating must replace, not duplicate, the allocation.');

        $allocation = DividendAllocation::where('dividend_period_id', $period->id)->firstOrFail();
        $this->assertGreaterThan(10000.0, (float) $allocation->average_share_balance, 'The second purchase should raise the average.');
    }
}
