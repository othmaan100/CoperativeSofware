<?php

namespace Tests\Feature;

use App\Livewire\Loans\MyLoans;
use App\Livewire\Treasurer\LoanRepaymentBatches;
use App\Livewire\Treasurer\LoanRepaymentBatchShow;
use App\Livewire\Treasurer\LoanRepaymentReversals;
use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\LoanRepaymentBatch;
use App\Models\LoanRepaymentReversal;
use App\Models\Member;
use App\Models\User;
use Database\Seeders\LoanSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SavingsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class LoanRepaymentReversalTest extends TestCase
{
    use RefreshDatabase;

    protected User $treasurer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
        $this->seed(SavingsSeeder::class);
        $this->seed(LoanSeeder::class);

        $this->treasurer = User::factory()->create();
        $this->treasurer->assignRole('treasurer');
    }

    protected function makeMember(string $staffId = 'FCET-8001'): Member
    {
        $user = User::factory()->create();
        $user->assignRole('member');

        return Member::factory()->create(['user_id' => $user->id, 'staff_id' => $staffId, 'status' => 'active']);
    }

    protected function makeLoan(Member $member, float $outstanding): Loan
    {
        $product = LoanProduct::where('code', LoanProduct::REGULAR)->first();

        $loan = Loan::create([
            'member_id' => $member->id,
            'loan_product_id' => $product->id,
            'loan_no' => Loan::generateLoanNo(),
            'principal_amount' => $outstanding,
            'interest_admin_pct' => 0,
            'interest_profit_pct' => 0,
            'total_interest' => 0,
            'interest_admin_amount' => 0,
            'interest_profit_amount' => 0,
            'total_repayable' => $outstanding,
            'tenure_months' => 1,
            'monthly_installment' => $outstanding,
            'outstanding_balance' => $outstanding,
            'status' => 'active',
            'applied_at' => now(),
            'disbursed_at' => now(),
        ]);
        $loan->generateSchedule(now());

        return $loan;
    }

    protected function postSalaryBatch(string $csv): LoanRepaymentBatch
    {
        Livewire::actingAs($this->treasurer)->test(LoanRepaymentBatches::class)
            ->set('period', '2025-07')
            ->set('file', UploadedFile::fake()->createWithContent('repayments.csv', $csv))
            ->call('processUpload');

        $batch = LoanRepaymentBatch::latest('id')->firstOrFail();
        Livewire::actingAs($this->treasurer)->test(LoanRepaymentBatchShow::class, ['batch' => $batch])->call('post');

        return $batch;
    }

    public function test_excess_salary_deduction_is_reversed_off_the_loan_and_tracked(): void
    {
        $member = $this->makeMember();
        $loan = $this->makeLoan($member, 15000);

        $this->postSalaryBatch("staff_id,loan_no,amount\nFCET-8001,{$loan->loan_no},20000\n");

        $loan->refresh();
        $this->assertSame('closed', $loan->status);
        $this->assertEquals(0, (float) $loan->outstanding_balance);

        $repayment = $loan->repaymentTransactions()->where('type', 'salary_deduction')->firstOrFail();
        $this->assertEquals(20000, (float) $repayment->amount, 'The full deduction is still recorded.');

        $reversalTxn = $loan->repaymentTransactions()->where('type', 'reversal')->firstOrFail();
        $this->assertEquals(5000, (float) $reversalTxn->amount);
        $this->assertSame($repayment->id, $reversalTxn->reversed_transaction_id);

        $reversal = LoanRepaymentReversal::firstOrFail();
        $this->assertEquals(5000, (float) $reversal->amount);
        $this->assertSame(LoanRepaymentReversal::STATUS_AWAITING_CHOICE, $reversal->status);
        $this->assertSame(1, $member->user->notifications()->count());
    }

    public function test_member_applies_excess_to_another_loan_and_treasurer_completes_it(): void
    {
        $member = $this->makeMember();
        $closing = $this->makeLoan($member, 15000);
        $other = $this->makeLoan($member, 50000);
        $closing->recordRepayment('salary_deduction', 20000, $this->treasurer->id);
        $reversal = LoanRepaymentReversal::firstOrFail();

        Livewire::actingAs($member->user)->test(MyLoans::class)
            ->assertSee('Excess Repayments')
            ->call('openReversal', $reversal->id)
            ->assertSet('reversal_action', 'apply_to_loan')
            ->set('reversal_target_loan_id', (string) $other->id)
            ->call('submitReversalChoice')
            ->assertHasNoErrors();

        $this->assertSame(LoanRepaymentReversal::STATUS_AWAITING_PROCESSING, $reversal->fresh()->status);

        Livewire::actingAs($this->treasurer)->test(LoanRepaymentReversals::class)->call('applyToLoan', $reversal->id);

        $reversal->refresh();
        $this->assertSame(LoanRepaymentReversal::STATUS_COMPLETED, $reversal->status);
        $this->assertNotNull($reversal->applied_transaction_id);
        $this->assertSame($this->treasurer->id, $reversal->processed_by);
        $this->assertEquals(45000, (float) $other->fresh()->outstanding_balance);
    }

    public function test_deduction_on_a_closed_loan_becomes_excess_and_can_be_refunded(): void
    {
        $member = $this->makeMember();
        $loan = $this->makeLoan($member, 5000);
        $loan->recordRepayment('salary_deduction', 5000, $this->treasurer->id);
        $this->assertSame('closed', $loan->fresh()->status);

        $this->postSalaryBatch("staff_id,loan_no,amount\nFCET-8001,{$loan->loan_no},10000\n");
        $reversal = LoanRepaymentReversal::firstOrFail();
        $this->assertEquals(10000, (float) $reversal->amount);

        Livewire::actingAs($member->user)->test(MyLoans::class)
            ->call('openReversal', $reversal->id)
            ->assertSet('reversal_action', 'refund')
            ->call('submitReversalChoice')
            ->assertHasErrors(['refund_bank_name', 'refund_account_number'])
            ->set('refund_bank_name', 'First Bank')
            ->set('refund_account_number', '0123456789')
            ->call('submitReversalChoice')
            ->assertHasNoErrors();

        Livewire::actingAs($this->treasurer)->test(LoanRepaymentReversals::class)
            ->call('openRefund', $reversal->id)
            ->call('completeRefund')
            ->assertHasErrors('refund_reference')
            ->set('refund_reference', 'TRF-998877')
            ->call('completeRefund');

        $reversal->refresh();
        $this->assertSame(LoanRepaymentReversal::STATUS_COMPLETED, $reversal->status);
        $this->assertSame('TRF-998877', $reversal->refund_reference);
    }

    public function test_applying_more_than_the_target_loan_owes_creates_a_new_excess(): void
    {
        $member = $this->makeMember();
        $source = $this->makeLoan($member, 1000);
        $target = $this->makeLoan($member, 3000);
        $source->recordRepayment('salary_deduction', 9000, $this->treasurer->id);

        $reversal = LoanRepaymentReversal::firstOrFail();
        $reversal->update(['status' => 'awaiting_processing', 'resolution' => 'apply_to_loan', 'target_loan_id' => $target->id, 'chosen_at' => now()]);

        Livewire::actingAs($this->treasurer)->test(LoanRepaymentReversals::class)->call('applyToLoan', $reversal->id);

        $this->assertSame('closed', $target->fresh()->status);
        $remainder = LoanRepaymentReversal::where('loan_id', $target->id)->firstOrFail();
        $this->assertEquals(5000, (float) $remainder->amount);
    }

    public function test_target_loan_closed_before_processing_sends_it_back_to_the_member(): void
    {
        $member = $this->makeMember();
        $source = $this->makeLoan($member, 1000);
        $target = $this->makeLoan($member, 3000);
        $source->recordRepayment('salary_deduction', 2000, $this->treasurer->id);

        $reversal = LoanRepaymentReversal::firstOrFail();
        $reversal->update(['status' => 'awaiting_processing', 'resolution' => 'apply_to_loan', 'target_loan_id' => $target->id, 'chosen_at' => now()]);
        $target->update(['status' => 'closed', 'outstanding_balance' => 0]);

        Livewire::actingAs($this->treasurer)->test(LoanRepaymentReversals::class)->call('applyToLoan', $reversal->id);

        $reversal->refresh();
        $this->assertSame(LoanRepaymentReversal::STATUS_AWAITING_CHOICE, $reversal->status);
        $this->assertNull($reversal->target_loan_id);
        $this->assertSame(0, $target->repaymentTransactions()->count());
    }

    public function test_repayment_within_the_outstanding_balance_creates_no_reversal(): void
    {
        $loan = $this->makeLoan($this->makeMember(), 10000);
        $loan->recordRepayment('salary_deduction', 4000, $this->treasurer->id);

        $this->assertSame(0, LoanRepaymentReversal::count());
        $this->assertEquals(6000, (float) $loan->fresh()->outstanding_balance);
    }

    public function test_member_cannot_act_on_another_members_excess(): void
    {
        $owner = $this->makeMember('FCET-8001');
        $loan = $this->makeLoan($owner, 1000);
        $loan->recordRepayment('salary_deduction', 2000, $this->treasurer->id);
        $reversal = LoanRepaymentReversal::firstOrFail();

        $intruder = $this->makeMember('FCET-8002');

        try {
            Livewire::actingAs($intruder->user)->test(MyLoans::class)->call('openReversal', $reversal->id);
            $this->fail('Another member must not be able to open this reversal.');
        } catch (\Throwable $e) {
            $this->assertSame(LoanRepaymentReversal::STATUS_AWAITING_CHOICE, $reversal->fresh()->status);
        }
    }

    public function test_treasurer_queue_requires_permission(): void
    {
        $member = $this->makeMember();

        Livewire::actingAs($member->user)->test(LoanRepaymentReversals::class)->assertForbidden();
    }
}
