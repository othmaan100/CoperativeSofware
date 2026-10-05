<?php

namespace Tests\Feature;

use App\Livewire\Chairman\LoanTenureApprovals;
use App\Livewire\Treasurer\LoanTenureChanges;
use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\LoanTenureChangeRequest;
use App\Models\Member;
use App\Models\User;
use App\Notifications\LoanTenureChangedNotification;
use Database\Seeders\LoanSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SavingsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class LoanTenureChangeTest extends TestCase
{
    use RefreshDatabase;

    protected User $treasurer;

    protected User $chairman;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
        $this->seed(SavingsSeeder::class);
        $this->seed(LoanSeeder::class);

        $this->treasurer = User::factory()->create();
        $this->treasurer->assignRole('treasurer');
        $this->chairman = User::factory()->create();
        $this->chairman->assignRole('chairman');
    }

    /** A 6-month loan of ₦60,000 (₦10,000 a month, no interest for easy sums). */
    protected function makeLoan(): Loan
    {
        $user = User::factory()->create();
        $user->assignRole('member');
        $member = Member::factory()->create(['user_id' => $user->id, 'staff_id' => 'FCET-9101', 'status' => 'active']);

        $loan = Loan::create([
            'member_id' => $member->id,
            'loan_product_id' => LoanProduct::where('code', LoanProduct::REGULAR)->first()->id,
            'loan_no' => Loan::generateLoanNo(),
            'principal_amount' => 60000,
            'interest_admin_pct' => 0,
            'interest_profit_pct' => 0,
            'total_interest' => 0,
            'interest_admin_amount' => 0,
            'interest_profit_amount' => 0,
            'total_repayable' => 60000,
            'tenure_months' => 6,
            'monthly_installment' => 10000,
            'outstanding_balance' => 60000,
            'status' => 'active',
            'applied_at' => now()->subMonths(3),
            'disbursed_at' => now()->subMonths(3),
        ]);
        $loan->generateSchedule(now()->subMonths(3));

        return $loan;
    }

    protected function requestIncrease(Loan $loan, int $tenure)
    {
        return Livewire::actingAs($this->treasurer)->test(LoanTenureChanges::class)
            ->call('openRequest', $loan->id)
            ->set('new_tenure', (string) $tenure)
            ->set('reason', 'Member asked for lower deductions')
            ->call('submitRequest');
    }

    public function test_treasurer_request_then_chairman_approval_reduces_monthly_repayment(): void
    {
        Notification::fake();
        $loan = $this->makeLoan();
        // Two installments paid, plus ₦5,000 towards the third: ₦35,000 left.
        $loan->recordRepayment('salary_deduction', 25000, $this->treasurer->id);

        $this->requestIncrease($loan, 9)->assertHasNoErrors();

        $request = LoanTenureChangeRequest::firstOrFail();
        $this->assertSame('pending', $request->status);
        $this->assertSame(6, $request->current_tenure_months);
        $this->assertEquals(5000, (float) $request->proposed_installment, '₦35,000 over the 7 installments not fully paid.');
        $this->assertEquals(10000, (float) $loan->fresh()->monthly_installment, 'Nothing changes until the Chairman approves.');

        Livewire::actingAs($this->chairman)->test(LoanTenureApprovals::class)
            ->assertSee($loan->loan_no)
            ->call('openApprove', $request->id)
            ->call('approve')
            ->assertHasNoErrors();

        $loan->refresh();
        $this->assertSame(9, (int) $loan->tenure_months);
        $this->assertEquals(5000, (float) $loan->monthly_installment);
        $this->assertSame('approved', $request->fresh()->status);
        $this->assertEquals(5000, (float) $request->fresh()->applied_installment);

        $schedules = $loan->schedules()->orderBy('installment_no')->get();
        $this->assertCount(9, $schedules);
        $this->assertSame(['paid', 'paid', 'partially_paid'], $schedules->take(3)->pluck('status')->all());
        $this->assertEquals(10000, (float) $schedules[2]->amount_due, 'Partly paid installment keeps its ₦5,000 and owes ₦5,000 more.');
        $this->assertEquals(35000, round($schedules->sum(fn ($s) => $s->balanceRemaining()), 2));
        $this->assertSame(
            $schedules[5]->due_date->copy()->addMonthsNoOverflow(3)->toDateString(),
            $schedules[8]->due_date->toDateString(),
        );

        Notification::assertSentTo($loan->member->user, LoanTenureChangedNotification::class);

        // Later repayments settle the re-spread schedule exactly.
        $loan->recordRepayment('salary_deduction', 35000, $this->treasurer->id);
        $this->assertSame('closed', $loan->fresh()->status);
        $this->assertSame(0, $loan->schedules()->where('status', '!=', 'paid')->count());
    }

    public function test_approval_uses_the_balance_at_approval_time(): void
    {
        $loan = $this->makeLoan();
        $this->requestIncrease($loan, 12);
        $request = LoanTenureChangeRequest::firstOrFail();
        $this->assertEquals(5000, (float) $request->proposed_installment);

        $loan->recordRepayment('salary_deduction', 10000, $this->treasurer->id);

        Livewire::actingAs($this->chairman)->test(LoanTenureApprovals::class)
            ->call('openApprove', $request->id)
            ->assertSee('differs from')
            ->call('approve');

        $this->assertEquals(round(50000 / 11, 2), (float) $loan->fresh()->monthly_installment);
        $this->assertEquals(50000, round($loan->schedules()->get()->sum(fn ($s) => $s->balanceRemaining()), 2));
    }

    public function test_chairman_can_decline_with_reason_and_loan_is_unchanged(): void
    {
        $loan = $this->makeLoan();
        $this->requestIncrease($loan, 10);
        $request = LoanTenureChangeRequest::firstOrFail();

        Livewire::actingAs($this->chairman)->test(LoanTenureApprovals::class)
            ->call('openDecline', $request->id)
            ->call('decline')
            ->assertHasErrors(['chairman_note' => 'required'])
            ->set('chairman_note', 'Repayment record is poor')
            ->call('decline');

        $this->assertSame('declined', $request->fresh()->status);
        $this->assertSame(6, (int) $loan->fresh()->tenure_months);
        $this->assertCount(6, $loan->schedules);
    }

    public function test_request_must_lengthen_the_tenure_and_only_one_can_be_pending(): void
    {
        $loan = $this->makeLoan();

        $this->requestIncrease($loan, 6)->assertHasErrors('new_tenure');
        $this->requestIncrease($loan, 121)->assertHasErrors('new_tenure');
        $this->requestIncrease($loan, 8)->assertHasNoErrors();
        $this->requestIncrease($loan, 10)->assertHasErrors('new_tenure');

        $this->assertSame(1, LoanTenureChangeRequest::count());
    }

    public function test_closed_loans_cannot_be_extended(): void
    {
        $loan = $this->makeLoan();
        $loan->recordRepayment('salary_deduction', 60000, $this->treasurer->id);

        $this->requestIncrease($loan, 9)->assertHasErrors('new_tenure');
    }

    public function test_screens_are_restricted_to_treasurer_and_chairman(): void
    {
        $member = User::factory()->create();
        $member->assignRole('member');

        Livewire::actingAs($member)->test(LoanTenureChanges::class)->assertForbidden();
        Livewire::actingAs($member)->test(LoanTenureApprovals::class)->assertForbidden();
        Livewire::actingAs($this->treasurer)->test(LoanTenureApprovals::class)->assertForbidden();
    }
}
