<?php

namespace Tests\Feature;

use App\Livewire\Chairman\LoanAuthorizations;
use App\Livewire\Loans\ApplyForLoan;
use App\Livewire\Loans\GuarantorRequests;
use App\Livewire\Loans\MyLoans;
use App\Livewire\Treasurer\LoanApplications;
use App\Livewire\Treasurer\LoanImports;
use App\Livewire\Treasurer\LoanImportShow;
use App\Livewire\Treasurer\LoanRepaymentBatches;
use App\Livewire\Treasurer\LoanRepaymentBatchShow;
use App\Livewire\Treasurer\LoanRepaymentIntents;
use App\Livewire\Treasurer\SavingsLoanRepayments;
use App\Livewire\Savings\RequestWithdrawal;
use App\Models\Loan;
use App\Models\LoanGuarantor;
use App\Models\LoanProduct;
use App\Models\LoanSavingsRepaymentRequest;
use App\Models\Member;
use App\Models\SavingsAccount;
use App\Models\SavingsProduct;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Database\Seeders\LoanSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SavingsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Livewire\Livewire;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
        $this->seed(SavingsSeeder::class);
        $this->seed(LoanSeeder::class);
    }

    protected function makeActiveMember(array $overrides = []): Member
    {
        $user = User::factory()->create();
        $user->assignRole('member');

        return Member::factory()->create(array_merge([
            'user_id' => $user->id,
            'status' => 'active',
            'applied_at' => now()->subYear(),
        ], $overrides));
    }

    protected function withSavings(Member $member, float $balance): SavingsAccount
    {
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        $account = SavingsAccount::openFor($member, $regular);
        if ($balance > 0) {
            $account->recordTransaction('contribution_deduction', $balance, 'Opening contribution', null);
        }

        return $account->fresh();
    }

    protected function makeActiveLoan(Member $borrower, float $outstanding = 11000): Loan
    {
        $product = LoanProduct::where('code', 'regular')->first();

        $loan = Loan::create([
            'member_id' => $borrower->id,
            'loan_product_id' => $product->id,
            'loan_no' => Loan::generateLoanNo(),
            'principal_amount' => 10000,
            'interest_admin_pct' => $product->interest_admin_pct,
            'interest_profit_pct' => $product->interest_profit_pct,
            'total_interest' => 1000,
            'interest_admin_amount' => 200,
            'interest_profit_amount' => 800,
            'total_repayable' => $outstanding,
            'tenure_months' => 5,
            'monthly_installment' => 2200,
            'outstanding_balance' => $outstanding,
            'status' => 'active',
            'applied_at' => now(),
            'disbursed_at' => now(),
        ]);
        $loan->generateSchedule(now());

        return $loan;
    }

    public function test_full_regular_loan_lifecycle_with_guarantor_acceptance(): void
    {
        $borrower = $this->makeActiveMember(['staff_id' => 'FCET-7001']);
        $this->withSavings($borrower, 50000); // 3x multiplier => max 150,000

        $guarantorMember = $this->makeActiveMember(['staff_id' => 'FCET-7002']);
        $this->withSavings($guarantorMember, 20000);

        Livewire::actingAs($borrower->user)
            ->test(ApplyForLoan::class)
            ->set('loan_product_id', (string) LoanProduct::where('code', 'regular')->value('id'))
            ->set('principal_amount', '100000')
            ->set('tenure_months', '10')
            ->set('guarantor_1_staff_id', 'FCET-7002')
            ->set('guarantor_1_pledged_amount', '20000')
            ->call('submit');

        $loan = Loan::firstOrFail();
        $this->assertSame('pending_guarantor', $loan->status, 'A loan requiring a guarantor must wait for acceptance before reaching the Treasurer.');
        $this->assertEquals(110000, (float) $loan->total_repayable, 'Flat 10% (2% admin + 8% profit) on 100,000 principal.');
        $this->assertEquals(2000, (float) $loan->interest_admin_amount);
        $this->assertEquals(8000, (float) $loan->interest_profit_amount);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        // Not yet visible in the Treasurer's "ready for review" queue.
        $this->assertSame(0, Loan::where('status', 'pending')->count());

        // Guarantor accepts.
        $guarantorRecord = LoanGuarantor::firstOrFail();
        Livewire::actingAs($guarantorMember->user)
            ->test(GuarantorRequests::class)
            ->call('accept', $guarantorRecord->id);

        $this->assertSame('accepted', $guarantorRecord->fresh()->status);
        $this->assertSame('pending', $loan->fresh()->status, 'Once the required guarantor accepts, the loan should move to the Treasurer queue.');

        // Treasurer endorses.
        Livewire::actingAs($treasurer)
            ->test(LoanApplications::class)
            ->call('openReview', $loan->id)
            ->set('tenure_months', '10')
            ->call('endorse');

        $this->assertSame('treasurer_endorsed', $loan->fresh()->status);

        // Chairman authorizes.
        $chairman = User::factory()->create();
        $chairman->assignRole('chairman');

        Livewire::actingAs($chairman)
            ->test(LoanAuthorizations::class)
            ->call('openAuthorize', $loan->id)
            ->call('authorize_');

        $this->assertSame('chairman_authorized', $loan->fresh()->status);

        // Treasurer disburses.
        Livewire::actingAs($treasurer)
            ->test(LoanApplications::class)
            ->set('tab', 'disbursement')
            ->call('openDisburse', $loan->id)
            ->set('disbursement_method', 'bank_transfer')
            ->set('disbursement_reference', 'REF-001')
            ->call('disburse');

        $loan->refresh();
        $this->assertSame('active', $loan->status);
        $this->assertEquals(110000, (float) $loan->outstanding_balance);
        $this->assertSame(10, $loan->schedules()->count());
        $this->assertEquals(110000, (float) $loan->schedules()->sum('amount_due'), 'Schedule must sum exactly to the total repayable, rounding absorbed in the last installment.');

        // Post a full repayment via the batch mechanism.
        $csv = "staff_id,loan_no,amount\nFCET-7001,{$loan->loan_no},110000\n";
        $file = UploadedFile::fake()->createWithContent('loan-repayments.csv', $csv);

        Livewire::actingAs($treasurer)
            ->test(LoanRepaymentBatches::class)
            ->set('period', '2026-10')
            ->set('file', $file)
            ->call('processUpload');

        $batch = \App\Models\LoanRepaymentBatch::firstOrFail();
        $this->assertSame('validated', $batch->status);
        $this->assertEquals(110000, (float) $batch->total_amount);

        Livewire::actingAs($treasurer)
            ->test(LoanRepaymentBatchShow::class, ['batch' => $batch])
            ->call('post');

        $loan->refresh();
        $this->assertSame('closed', $loan->status, 'Loan must close once fully repaid.');
        $this->assertEquals(0, (float) $loan->outstanding_balance);
        $this->assertNotNull($loan->closed_at);
    }

    public function test_guarantor_decline_terminates_the_application(): void
    {
        $borrower = $this->makeActiveMember(['staff_id' => 'FCET-7101']);
        $this->withSavings($borrower, 50000);
        $guarantorMember = $this->makeActiveMember(['staff_id' => 'FCET-7102']);
        $this->withSavings($guarantorMember, 20000);

        Livewire::actingAs($borrower->user)
            ->test(ApplyForLoan::class)
            ->set('loan_product_id', (string) LoanProduct::where('code', 'regular')->value('id'))
            ->set('principal_amount', '50000')
            ->set('tenure_months', '6')
            ->set('guarantor_1_staff_id', 'FCET-7102')
            ->set('guarantor_1_pledged_amount', '10000')
            ->call('submit');

        $loan = Loan::firstOrFail();
        $guarantorRecord = LoanGuarantor::firstOrFail();

        Livewire::actingAs($guarantorMember->user)
            ->test(GuarantorRequests::class)
            ->call('decline', $guarantorRecord->id);

        $this->assertSame('declined', $guarantorRecord->fresh()->status);
        $this->assertSame('guarantor_declined', $loan->fresh()->status);
    }

    public function test_application_is_blocked_beyond_the_savings_linked_multiplier(): void
    {
        $borrower = $this->makeActiveMember(['staff_id' => 'FCET-7201']);
        $this->withSavings($borrower, 10000); // 3x => max 30,000

        Livewire::actingAs($borrower->user)
            ->test(ApplyForLoan::class)
            ->set('loan_product_id', (string) LoanProduct::where('code', 'regular')->value('id'))
            ->set('principal_amount', '100000')
            ->set('tenure_months', '6')
            ->set('guarantor_1_staff_id', 'FCET-DOES-NOT-MATTER')
            ->set('guarantor_1_pledged_amount', '5000')
            ->call('submit')
            ->assertHasErrors('principal_amount');

        $this->assertSame(0, Loan::count(), 'An over-limit application must never be persisted.');
    }

    public function test_overdue_sweep_escalates_to_default_and_calls_the_guarantor_pledge(): void
    {
        $borrower = $this->makeActiveMember(['staff_id' => 'FCET-7301']);
        $this->withSavings($borrower, 50000);
        $guarantorMember = $this->makeActiveMember(['staff_id' => 'FCET-7302']);
        $guarantorAccount = $this->withSavings($guarantorMember, 30000);

        $product = LoanProduct::where('code', 'regular')->first();
        $product->update(['default_after_days_overdue' => 5, 'guarantor_grace_days' => 2]);

        $loan = Loan::create([
            'member_id' => $borrower->id,
            'loan_product_id' => $product->id,
            'loan_no' => Loan::generateLoanNo(),
            'principal_amount' => 20000,
            'interest_admin_pct' => $product->interest_admin_pct,
            'interest_profit_pct' => $product->interest_profit_pct,
            'total_interest' => 2000,
            'interest_admin_amount' => 400,
            'interest_profit_amount' => 1600,
            'total_repayable' => 22000,
            'tenure_months' => 2,
            'monthly_installment' => 11000,
            'multiplier_applied' => 3,
            'outstanding_balance' => 22000,
            'status' => 'active',
            'applied_at' => now()->subDays(20),
            'disbursed_at' => now()->subDays(20),
        ]);
        $loan->generateSchedule(now()->subDays(20));
        $loan->guarantors()->create([
            'guarantor_member_id' => $guarantorMember->id,
            'pledged_amount' => 15000,
            'status' => LoanGuarantor::STATUS_ACCEPTED,
            'accepted_at' => now()->subDays(20),
        ]);

        // Force the first installment's due date squarely into the past.
        $loan->schedules()->first()->update(['due_date' => now()->subDays(10)->toDateString()]);

        Artisan::call('loans:process-overdue');

        $loan->refresh();
        $this->assertSame('defaulted', $loan->status, 'An installment overdue past the configured threshold must escalate to defaulted.');
        $this->assertNotNull($loan->defaulted_at);

        // Grace period (2 days) has not elapsed yet immediately after defaulting.
        $guarantorRecord = $loan->guarantors()->first();
        $this->assertNull($guarantorRecord->fresh()->called_at);

        // Travel past the grace period and sweep again.
        $this->travel(3)->days();
        Artisan::call('loans:process-overdue');

        $guarantorRecord->refresh();
        $this->assertNotNull($guarantorRecord->called_at, 'Guarantor pledge must be called once the grace period elapses.');
        $this->assertEquals(30000 - 15000, (float) $guarantorAccount->fresh()->balance, 'Guarantor savings must be debited by the pledged amount.');
        $this->assertEquals('loan_guarantor_deduction', $guarantorAccount->fresh()->transactions()->first()->type);
    }

    public function test_voluntary_lump_sum_repayment_requires_treasurer_confirmation(): void
    {
        $borrower = $this->makeActiveMember(['staff_id' => 'FCET-7401']);
        $product = LoanProduct::where('code', 'regular')->first();

        $loan = Loan::create([
            'member_id' => $borrower->id,
            'loan_product_id' => $product->id,
            'loan_no' => Loan::generateLoanNo(),
            'principal_amount' => 10000,
            'interest_admin_pct' => $product->interest_admin_pct,
            'interest_profit_pct' => $product->interest_profit_pct,
            'total_interest' => 1000,
            'interest_admin_amount' => 200,
            'interest_profit_amount' => 800,
            'total_repayable' => 11000,
            'tenure_months' => 5,
            'monthly_installment' => 2200,
            'outstanding_balance' => 11000,
            'status' => 'active',
            'applied_at' => now(),
            'disbursed_at' => now(),
        ]);
        $loan->generateSchedule(now());

        Livewire::actingAs($borrower->user)
            ->test(MyLoans::class)
            ->call('openRepay', $loan->id)
            ->set('repay_amount', '3000')
            ->call('submitRepayment');

        $this->assertEquals(11000, (float) $loan->fresh()->outstanding_balance, 'Balance must not move until the Treasurer confirms.');

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');
        $intent = \App\Models\LoanRepaymentIntent::firstOrFail();

        Livewire::actingAs($treasurer)
            ->test(LoanRepaymentIntents::class)
            ->call('confirm', $intent->id);

        $loan->refresh();
        $this->assertEquals(8000, (float) $loan->outstanding_balance);
        $this->assertSame('confirmed', $intent->fresh()->status);
    }

    public function test_repayment_receipt_is_uploaded_and_downloadable_only_by_owner_and_treasurer(): void
    {
        $borrower = $this->makeActiveMember(['staff_id' => 'FCET-7402']);
        $stranger = $this->makeActiveMember(['staff_id' => 'FCET-7403']);
        $product = LoanProduct::where('code', 'regular')->first();

        $loan = Loan::create([
            'member_id' => $borrower->id,
            'loan_product_id' => $product->id,
            'loan_no' => Loan::generateLoanNo(),
            'principal_amount' => 10000,
            'interest_admin_pct' => $product->interest_admin_pct,
            'interest_profit_pct' => $product->interest_profit_pct,
            'total_interest' => 1000,
            'interest_admin_amount' => 200,
            'interest_profit_amount' => 800,
            'total_repayable' => 11000,
            'tenure_months' => 5,
            'monthly_installment' => 2200,
            'outstanding_balance' => 11000,
            'status' => 'active',
            'applied_at' => now(),
            'disbursed_at' => now(),
        ]);
        $loan->generateSchedule(now());

        $receipt = UploadedFile::fake()->create('teller.jpg', 100, 'image/jpeg');

        Livewire::actingAs($borrower->user)
            ->test(MyLoans::class)
            ->call('openRepay', $loan->id)
            ->set('repay_amount', '3000')
            ->set('repay_receipt', $receipt)
            ->call('submitRepayment');

        $intent = \App\Models\LoanRepaymentIntent::firstOrFail();
        $this->assertNotNull($intent->receipt_path);
        $this->assertSame('teller.jpg', $intent->receipt_original_filename);
        \Illuminate\Support\Facades\Storage::disk('local')->assertExists($intent->receipt_path);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        $this->actingAs($treasurer)->get(route('loan-repayment-intents.receipt', $intent))->assertOk();
        $this->actingAs($borrower->user)->get(route('loan-repayment-intents.receipt', $intent))->assertOk();
        $this->actingAs($stranger->user)->get(route('loan-repayment-intents.receipt', $intent))->assertForbidden();
    }

    public function test_legacy_loan_import_lands_active_without_the_approval_workflow(): void
    {
        $member = $this->makeActiveMember(['staff_id' => 'FCET-7501']);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        $csv = "staff_id,loan_product,principal_amount,total_interest,tenure_months,disbursed_date,amount_repaid\nFCET-7501,regular,100000,10000,10,2025-01-01,33000\n";
        $file = UploadedFile::fake()->createWithContent('legacy-loans.csv', $csv);

        Livewire::actingAs($treasurer)
            ->test(LoanImports::class)
            ->set('file', $file)
            ->call('processUpload');

        $batch = \App\Models\LoanImportBatch::firstOrFail();
        $this->assertSame('validated', $batch->status);
        $this->assertCount(1, $batch->matchedRows());

        Livewire::actingAs($treasurer)
            ->test(LoanImportShow::class, ['batch' => $batch])
            ->call('import');

        $loan = Loan::firstOrFail();
        $this->assertTrue((bool) $loan->is_legacy_import);
        $this->assertSame('active', $loan->status, 'A legacy loan lands directly as active — it never enters the application/approval workflow.');
        $this->assertEquals(110000 - 33000, (float) $loan->outstanding_balance);
        $this->assertSame(10, $loan->schedules()->count());
        $this->assertEquals(33000, (float) $loan->schedules()->sum('amount_paid'), 'Historical repayment must be back-filled across the schedule.');
    }

    public function test_member_can_request_and_treasurer_can_approve_a_repayment_from_savings(): void
    {
        $borrower = $this->makeActiveMember(['staff_id' => 'FCET-7701']);
        $account = $this->withSavings($borrower, 20000);
        $loan = $this->makeActiveLoan($borrower, 11000);

        Livewire::actingAs($borrower->user)
            ->test(MyLoans::class)
            ->call('openRepayFromSavings', $loan->id)
            ->set('repay_from_savings_account_id', (string) $account->id)
            ->set('repay_from_savings_amount', '5000')
            ->call('submitRepayFromSavings')
            ->assertHasNoErrors();

        $request = LoanSavingsRepaymentRequest::firstOrFail();
        $this->assertSame(LoanSavingsRepaymentRequest::STATUS_PENDING, $request->status);
        $this->assertEquals(20000, (float) $account->fresh()->balance, 'Balance must not move until the Treasurer approves.');
        $this->assertEquals(11000, (float) $loan->fresh()->outstanding_balance);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(SavingsLoanRepayments::class)
            ->call('approve', $request->id);

        $request->refresh();
        $this->assertSame(LoanSavingsRepaymentRequest::STATUS_APPROVED, $request->status);
        $this->assertEquals(15000, (float) $account->fresh()->balance);
        $this->assertEquals(6000, (float) $loan->fresh()->outstanding_balance);
        $this->assertSame('loan_repayment_transfer', $account->fresh()->transactions()->first()->type);
        $this->assertSame('savings_transfer', $loan->fresh()->repaymentTransactions()->first()->type);
        $this->assertNotNull($request->savings_transaction_id);
        $this->assertNotNull($request->loan_repayment_transaction_id);
    }

    public function test_member_cannot_request_more_than_their_withdrawable_savings_balance(): void
    {
        $borrower = $this->makeActiveMember(['staff_id' => 'FCET-7702']);
        $account = $this->withSavings($borrower, 5000);
        $loan = $this->makeActiveLoan($borrower, 11000);

        Livewire::actingAs($borrower->user)
            ->test(MyLoans::class)
            ->call('openRepayFromSavings', $loan->id)
            ->set('repay_from_savings_account_id', (string) $account->id)
            ->set('repay_from_savings_amount', '5000.01') // 1 kobo over the balance
            ->call('submitRepayFromSavings')
            ->assertHasErrors(['repay_from_savings_amount']);

        $this->assertSame(0, LoanSavingsRepaymentRequest::count());
    }

    public function test_member_cannot_request_more_than_the_loan_outstanding_balance(): void
    {
        $borrower = $this->makeActiveMember(['staff_id' => 'FCET-7703']);
        $account = $this->withSavings($borrower, 50000);
        $loan = $this->makeActiveLoan($borrower, 3000); // owes far less than the savings balance

        Livewire::actingAs($borrower->user)
            ->test(MyLoans::class)
            ->call('openRepayFromSavings', $loan->id)
            ->set('repay_from_savings_account_id', (string) $account->id)
            ->set('repay_from_savings_amount', '5000')
            ->call('submitRepayFromSavings')
            ->assertHasErrors(['repay_from_savings_amount']);

        $this->assertSame(0, LoanSavingsRepaymentRequest::count());
    }

    public function test_treasurer_can_decline_a_savings_repayment_request(): void
    {
        $borrower = $this->makeActiveMember(['staff_id' => 'FCET-7704']);
        $account = $this->withSavings($borrower, 20000);
        $loan = $this->makeActiveLoan($borrower, 11000);

        Livewire::actingAs($borrower->user)
            ->test(MyLoans::class)
            ->call('openRepayFromSavings', $loan->id)
            ->set('repay_from_savings_account_id', (string) $account->id)
            ->set('repay_from_savings_amount', '5000')
            ->call('submitRepayFromSavings');

        $request = LoanSavingsRepaymentRequest::firstOrFail();
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(SavingsLoanRepayments::class)
            ->call('openDecline', $request->id)
            ->set('decline_reason', 'Member asked to cancel.')
            ->call('decline');

        $request->refresh();
        $this->assertSame(LoanSavingsRepaymentRequest::STATUS_DECLINED, $request->status);
        $this->assertEquals(20000, (float) $account->fresh()->balance, 'A declined request must never move money.');
        $this->assertEquals(11000, (float) $loan->fresh()->outstanding_balance);
    }

    public function test_a_pending_savings_repayment_request_reduces_availability_for_a_new_withdrawal(): void
    {
        $borrower = $this->makeActiveMember(['staff_id' => 'FCET-7705']);
        $account = $this->withSavings($borrower, 10000);
        $loan = $this->makeActiveLoan($borrower, 11000);

        Livewire::actingAs($borrower->user)
            ->test(MyLoans::class)
            ->call('openRepayFromSavings', $loan->id)
            ->set('repay_from_savings_account_id', (string) $account->id)
            ->set('repay_from_savings_amount', '8000')
            ->call('submitRepayFromSavings');

        // Only 2000 should now be withdrawable (10000 balance - 8000 committed).
        $this->assertEquals(2000, $account->fresh()->withdrawableBalance());

        Livewire::actingAs($borrower->user)
            ->test(RequestWithdrawal::class)
            ->set('savings_account_id', (string) $account->id)
            ->set('requested_amount', '5000') // exceeds the 2000 actually available
            ->set('bank_name', 'First Bank')
            ->set('account_number', '0123456789')
            ->call('submit')
            ->assertHasErrors(['requested_amount']);

        $this->assertSame(0, WithdrawalRequest::count());
    }

    public function test_treasurer_approval_is_reblocked_if_the_balance_shrank_after_the_request_was_made(): void
    {
        $borrower = $this->makeActiveMember(['staff_id' => 'FCET-7706']);
        $account = $this->withSavings($borrower, 10000);
        $loan = $this->makeActiveLoan($borrower, 11000);

        Livewire::actingAs($borrower->user)
            ->test(MyLoans::class)
            ->call('openRepayFromSavings', $loan->id)
            ->set('repay_from_savings_account_id', (string) $account->id)
            ->set('repay_from_savings_amount', '8000')
            ->call('submitRepayFromSavings');

        $request = LoanSavingsRepaymentRequest::firstOrFail();

        // The balance drops (e.g. a withdrawal was disbursed) after the
        // request was submitted but before the Treasurer gets to it.
        $account->recordTransaction('withdrawal', 7000, 'Disbursed withdrawal', null);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(SavingsLoanRepayments::class)
            ->call('approve', $request->id);

        $request->refresh();
        $this->assertSame(LoanSavingsRepaymentRequest::STATUS_PENDING, $request->status, 'Approval must be re-blocked when funds are no longer sufficient.');
        $this->assertEquals(3000, (float) $account->fresh()->balance);
        $this->assertEquals(11000, (float) $loan->fresh()->outstanding_balance);
    }
}
