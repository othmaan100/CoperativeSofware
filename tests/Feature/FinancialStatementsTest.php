<?php

namespace Tests\Feature;

use App\Livewire\Reports\FinancialStatements;
use App\Models\ApplicationFeePayment;
use App\Models\DividendPeriod;
use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\Member;
use App\Models\SavingsAccount;
use App\Models\SavingsProduct;
use App\Models\ShareAccount;
use App\Models\User;
use App\Services\FinancialStatementService;
use Illuminate\Support\Carbon;
use Database\Seeders\LoanSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SavingsSeeder;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\ShareSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FinancialStatementsTest extends TestCase
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

    /**
     * Builds one coherent, hand-computed scenario entirely within FY2025
     * (dividend_fy_start_month defaults to January), so every figure below
     * can be verified against the raw inputs.
     */
    protected function buildScenario(): Member
    {
        $member = $this->makeActiveMember();

        // Savings: +20,000 on 1 Feb 2025.
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->firstOrFail();
        $savings = SavingsAccount::openFor($member, $regular);
        Carbon::setTestNow('2025-02-01 00:00:00');
        $savings->recordTransaction('contribution_deduction', 20000, 'Test contribution', null);

        // Shares: 10 shares @ 1000 = 10,000 on 1 Mar 2025.
        $shares = ShareAccount::openFor($member);
        Carbon::setTestNow('2025-03-01 00:00:00');
        $shares->recordTransaction(type: ShareAccount::TYPE_PURCHASE, shares: 10, unitPrice: 1000, description: 'Test purchase', postedBy: null);
        Carbon::setTestNow();

        // Loan: 100,000 principal, 2%/8% split, disbursed 1 Apr 2025, then a
        // 50,000 repayment posted 1 Jun 2025 (outstanding 110,000 -> 60,000).
        $product = LoanProduct::query()->where('code', LoanProduct::REGULAR)->firstOrFail();
        $loan = Loan::create([
            'member_id' => $member->id,
            'loan_product_id' => $product->id,
            'loan_no' => 'LN-FS-TEST',
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
            'status' => 'active',
            'disbursed_at' => '2025-04-01',
        ]);

        Carbon::setTestNow('2025-06-01 00:00:00');
        $loan->recordRepayment(type: 'salary_deduction', amount: 50000, postedBy: null, description: 'Test repayment');
        Carbon::setTestNow();

        // Registration fee: 5,000 (20/80 split), paid 15 Jan 2025.
        $recorder = $this->makeUserWithRole('treasurer');
        ApplicationFeePayment::recordManual($member, 5000, $recorder->id, 'test');
        ApplicationFeePayment::query()->latest('id')->first()->update(['paid_at' => '2025-01-15']);

        // Dividend period posted 1 Jul 2025: 1,000 share dividend, 500 savings interest.
        $period = DividendPeriod::create([
            'label' => 'FY 2025 Test',
            'fy_start_date' => '2025-01-01',
            'fy_end_date' => '2025-12-31',
            'status' => DividendPeriod::STATUS_POSTED,
            'share_dividend_rate_pct' => 0,
            'savings_interest_rate_pct' => 0,
            'total_share_dividend_amount' => 1000,
            'total_savings_interest_amount' => 500,
            'opened_by' => $recorder->id,
            'posted_at' => '2025-07-01',
        ]);

        return $member;
    }

    public function test_point_in_time_balance_helpers(): void
    {
        $member = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->firstOrFail();
        $savings = SavingsAccount::openFor($member, $regular);

        $this->assertEquals(0.0, $savings->balanceAsOf(Carbon::parse('2025-01-01')));

        Carbon::setTestNow('2025-02-01 00:00:00');
        $savings->recordTransaction('contribution_deduction', 20000, 'Test', null);
        Carbon::setTestNow();

        $this->assertEquals(0.0, $savings->balanceAsOf(Carbon::parse('2025-01-31')));
        $this->assertEquals(20000.0, $savings->balanceAsOf(Carbon::parse('2025-02-01')));
        $this->assertEquals(20000.0, $savings->balanceAsOf(Carbon::parse('2025-12-31')));

        $product = LoanProduct::query()->where('code', LoanProduct::REGULAR)->firstOrFail();
        $loan = Loan::create([
            'member_id' => $member->id,
            'loan_product_id' => $product->id,
            'loan_no' => 'LN-PIT-TEST',
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
            'status' => 'active',
            'disbursed_at' => '2025-04-01',
        ]);

        $this->assertEquals(0.0, $loan->outstandingBalanceAsOf(Carbon::parse('2025-03-01')), 'Not yet disbursed.');
        $this->assertEquals(110000.0, $loan->outstandingBalanceAsOf(Carbon::parse('2025-04-01')), 'Disbursed, no repayment yet.');

        Carbon::setTestNow('2025-06-01 00:00:00');
        $loan->recordRepayment(type: 'salary_deduction', amount: 50000, postedBy: null, description: 'Test');
        Carbon::setTestNow();

        $this->assertEquals(110000.0, $loan->outstandingBalanceAsOf(Carbon::parse('2025-05-01')), 'Before the repayment.');
        $this->assertEquals(60000.0, $loan->outstandingBalanceAsOf(Carbon::parse('2025-06-01')), 'After the repayment.');
    }

    public function test_income_statement_matches_hand_computed_scenario(): void
    {
        $this->buildScenario();
        $service = new FinancialStatementService;

        $statement = $service->incomeStatement(Carbon::parse('2025-01-01'), Carbon::parse('2025-12-31 23:59:59'));

        $this->assertEquals(2000.0, $statement['income'][0]['amount']);
        $this->assertEquals(8000.0, $statement['income'][1]['amount']);
        $this->assertEquals(1000.0, $statement['income'][2]['amount']);
        $this->assertEquals(4000.0, $statement['income'][3]['amount']);
        $this->assertEquals(15000.0, $statement['total_income']);
        $this->assertEquals(500.0, $statement['total_expenses']);
        $this->assertEquals(14500.0, $statement['net_income']);
    }

    public function test_balance_sheet_balances_and_matches_hand_computed_scenario(): void
    {
        $this->buildScenario();
        $service = new FinancialStatementService;

        $sheet = $service->balanceSheet(Carbon::parse('2025-12-31 23:59:59'));

        $this->assertEquals(60000.0, $sheet['assets'][0]['amount'], 'Loans Receivable.');
        $this->assertEquals(20000.0, $sheet['liabilities'][0]['amount'], 'Member Savings.');
        $this->assertEquals(10000.0, $sheet['equity'][0]['amount'], 'Member Share Capital.');
        $this->assertEquals(13500.0, $sheet['equity'][1]['amount'], 'Retained Earnings = 14,500 net income - 1,000 dividends.');
        $this->assertEquals(-16500.0, $sheet['assets'][1]['amount'], 'Implied cash is the balancing figure.');

        $this->assertEquals($sheet['total_assets'], $sheet['total_liabilities_and_equity'], 'Assets must equal Liabilities + Equity by construction.');
        $this->assertEquals(43500.0, $sheet['total_assets']);
    }

    public function test_trial_balance_balances_and_matches_hand_computed_scenario(): void
    {
        $this->buildScenario();
        $service = new FinancialStatementService;

        $trial = $service->trialBalance(Carbon::parse('2025-01-01'), Carbon::parse('2025-12-31 23:59:59'));

        $this->assertTrue($trial['balances'], 'Debits must equal credits.');
        $this->assertEquals(45000.0, $trial['total_debits']);
        $this->assertEquals(45000.0, $trial['total_credits']);
    }

    public function test_retained_earnings_brought_forward_excludes_current_year_activity(): void
    {
        $this->buildScenario();
        $service = new FinancialStatementService;

        // All scenario activity is dated in 2025, so retained earnings as of
        // the end of 2024 (before any of it happened) must be zero.
        $this->assertEquals(0.0, $service->retainedEarningsAsOf(Carbon::parse('2024-12-31 23:59:59')));
    }

    public function test_only_authorized_roles_can_view_financial_statements(): void
    {
        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');
        $auditor = $this->makeUserWithRole('auditor');
        $member = $this->makeActiveMember();

        Livewire::actingAs($treasurer)->test(FinancialStatements::class)->assertOk();
        Livewire::actingAs($chairman)->test(FinancialStatements::class)->assertOk();
        Livewire::actingAs($auditor)->test(FinancialStatements::class)->assertOk();

        try {
            Livewire::actingAs($member->user)->test(FinancialStatements::class);
            $this->fail('Expected a plain member to be blocked from Financial Statements.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_report_renders_the_hand_computed_figures(): void
    {
        $this->buildScenario();
        $treasurer = $this->makeUserWithRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(FinancialStatements::class)
            ->set('startYear', 2025)
            ->assertSee('₦45,000.00') // trial balance totals
            ->set('tab', 'income_statement')
            ->assertSee('₦14,500.00') // net surplus
            ->set('tab', 'balance_sheet')
            ->assertSee('₦43,500.00'); // total assets
    }
}
