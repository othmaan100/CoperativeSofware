<?php

namespace Tests\Feature;

use App\Livewire\Chairman\WithdrawalsAuthorization;
use App\Livewire\Savings\MySavings;
use App\Livewire\Savings\RequestCompleteWithdrawal;
use App\Livewire\Savings\RequestWithdrawal;
use App\Livewire\Savings\ReversalsBoard;
use App\Livewire\Savings\SavingsStatement;
use App\Livewire\Treasurer\ContributionBatches;
use App\Livewire\Treasurer\ContributionBatchShow;
use App\Livewire\Treasurer\InitiateDeceasedDisbursement;
use App\Livewire\Treasurer\PendingApplications;
use App\Livewire\Treasurer\VoluntaryDeposits;
use App\Livewire\Treasurer\WithdrawalsReview;
use App\Livewire\Savings\WithdrawalConditionsManager;
use App\Models\Member;
use App\Models\SavingsAccount;
use App\Models\SavingsProduct;
use App\Models\SavingsTransaction;
use App\Models\Setting;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SavingsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class SavingsWithdrawalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
        $this->seed(SavingsSeeder::class);
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

    public function test_member_approval_auto_opens_a_regular_savings_account(): void
    {
        $applicantUser = User::factory()->create();
        $applicantUser->assignRole('applicant');

        $member = Member::factory()->create([
            'user_id' => $applicantUser->id,
            'status' => 'pending',
            'approved_at' => null,
            'membership_no' => null,
        ]);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(PendingApplications::class)
            ->call('openApprove', $member->id)
            ->set('approved_monthly_contribution', (string) $member->preferred_monthly_contribution)
            ->set('application_fee_paid', true)
            ->set('fee_override_note', 'Test override.')
            ->call('approve');

        $account = SavingsAccount::query()->where('member_id', $member->id)->first();

        $this->assertNotNull($account, 'Approving a member must auto-open a Regular Savings account.');
        $this->assertSame('0.00', (string) $account->balance);
    }

    public function test_contribution_batch_upload_validate_and_post_flow(): void
    {
        $matched = $this->makeActiveMember(['staff_id' => 'FCET-2001']);
        $unmatchedStaffId = 'FCET-9999';

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        $csv = "staff_id,amount\nFCET-2001,6000\n{$unmatchedStaffId},4000\n";
        $file = UploadedFile::fake()->createWithContent('contributions.csv', $csv);

        $component = Livewire::actingAs($treasurer)
            ->test(ContributionBatches::class)
            ->set('period', '2026-09')
            ->set('file', $file)
            ->call('processUpload');

        $batch = \App\Models\ContributionBatch::firstOrFail();
        $this->assertSame('validated', $batch->status);
        $this->assertSame(2, $batch->total_records);
        $this->assertEquals(6000, (float) $batch->total_amount, 'Only the matched row should count toward total_amount.');
        $this->assertCount(1, $batch->flaggedRows());

        Livewire::actingAs($treasurer)
            ->test(ContributionBatchShow::class, ['batch' => $batch])
            ->call('post');

        $batch->refresh();
        $this->assertSame('posted', $batch->status);

        $account = SavingsAccount::query()->where('member_id', $matched->id)->first();
        $this->assertEquals(6000, (float) $account->balance);
        $this->assertSame(1, $account->transactions()->count());
        $this->assertSame('contribution_deduction', $account->transactions()->first()->type);
    }

    public function test_contribution_csv_saved_by_excel_with_a_byte_order_mark_still_matches(): void
    {
        $this->makeActiveMember(['staff_id' => 'FCET-2201']);
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        $file = UploadedFile::fake()->createWithContent('contributions.csv', "\xEF\xBB\xBFstaff_id,amount\nFCET-2201,6000\n");
        Livewire::actingAs($treasurer)->test(ContributionBatches::class)
            ->set('period', '2026-09')->set('file', $file)->call('processUpload');

        $this->assertCount(1, \App\Models\ContributionBatch::firstOrFail()->matchedRows());
    }

    public function test_posting_without_a_regular_savings_product_shows_an_error_instead_of_a_404(): void
    {
        $this->makeActiveMember(['staff_id' => 'FCET-2101']);
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        $file = UploadedFile::fake()->createWithContent('contributions.csv', "staff_id,amount\nFCET-2101,6000\n");
        Livewire::actingAs($treasurer)->test(ContributionBatches::class)
            ->set('period', '2026-09')->set('file', $file)->call('processUpload');

        $batch = \App\Models\ContributionBatch::firstOrFail();
        SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->update(['code' => 'missing']);

        Livewire::actingAs($treasurer)
            ->test(ContributionBatchShow::class, ['batch' => $batch])
            ->call('post')
            ->assertOk()
            ->assertSee('Regular Savings product is not set up');

        $this->assertSame('validated', $batch->fresh()->status, 'The batch must stay unposted so it can be retried.');
    }

    public function test_contribution_template_lists_only_active_members_with_their_approved_amount(): void
    {
        $active = $this->makeActiveMember(['staff_id' => 'FCET-4001', 'approved_monthly_contribution' => 7500, 'ippis_number' => 'IPPIS-55501']);

        $pendingUser = User::factory()->create();
        $pendingUser->assignRole('applicant');
        Member::factory()->create(['user_id' => $pendingUser->id, 'staff_id' => 'FCET-4002', 'status' => 'pending']);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');
        $this->actingAs($treasurer);

        $response = (new ContributionBatches())->downloadTemplate();
        ob_start();
        $response->sendContent();
        $content = ob_get_clean();

        $this->assertStringContainsString('FCET-4001', $content);
        $this->assertStringContainsString('7500.00', $content);
        $this->assertStringContainsString('IPPIS-55501', $content, 'The template should include each member\'s IPPIS Number for reference.');
        $this->assertStringNotContainsString('FCET-4002', $content, 'Pending (non-active) members must not appear in the template.');

        $headerLine = strtok($content, "\n");
        $this->assertStringNotContainsString('full_name', $headerLine);
        $this->assertStringNotContainsString('department', $headerLine);
    }

    public function test_ippis_number_is_shown_on_the_batch_review_page_but_not_required_in_the_upload(): void
    {
        $member = $this->makeActiveMember(['staff_id' => 'FCET-4101', 'ippis_number' => 'IPPIS-77701']);
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        // The uploaded CSV itself carries no ippis_number column at all.
        $csv = "staff_id,amount\nFCET-4101,5000\n";
        $file = UploadedFile::fake()->createWithContent('contributions.csv', $csv);

        Livewire::actingAs($treasurer)
            ->test(ContributionBatches::class)
            ->set('period', '2026-09')
            ->set('file', $file)
            ->call('processUpload');

        $batch = \App\Models\ContributionBatch::firstOrFail();
        $this->assertSame('IPPIS-77701', $batch->rows[0]['ippis_number'], 'IPPIS Number should be looked up from the matched member record.');

        Livewire::actingAs($treasurer)
            ->test(ContributionBatchShow::class, ['batch' => $batch])
            ->assertSee('IPPIS-77701');
    }

    public function test_posted_batch_cannot_be_reposted(): void
    {
        $member = $this->makeActiveMember(['staff_id' => 'FCET-3001']);
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        $csv = "staff_id,amount\nFCET-3001,5000\n";
        $file = UploadedFile::fake()->createWithContent('contributions.csv', $csv);

        Livewire::actingAs($treasurer)->test(ContributionBatches::class)
            ->set('period', '2026-09')->set('file', $file)->call('processUpload');

        $batch = \App\Models\ContributionBatch::firstOrFail();
        Livewire::actingAs($treasurer)->test(ContributionBatchShow::class, ['batch' => $batch])->call('post');

        $accountBalanceAfterFirstPost = SavingsAccount::query()->where('member_id', $member->id)->first()->balance;

        try {
            Livewire::actingAs($treasurer)->test(ContributionBatchShow::class, ['batch' => $batch->fresh()])->call('post');
            $this->fail('Expected re-posting an already-posted batch to be blocked.');
        } catch (\Throwable $e) {
            // Expected: abort_unless() in post() refuses a non-validated batch.
        }

        $this->assertEquals(
            $accountBalanceAfterFirstPost,
            SavingsAccount::query()->where('member_id', $member->id)->first()->balance,
            'Re-posting must never double-credit the account.'
        );
    }

    public function test_voluntary_deposit_intent_and_confirmation_flow(): void
    {
        $member = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        SavingsAccount::openFor($member, $regular);

        Livewire::actingAs($member->user)
            ->test(MySavings::class)
            ->call('openDepositModal', $member->regularSavingsAccount()->id)
            ->set('deposit_amount', '2000')
            ->set('deposit_note', 'Cash deposit at bank')
            ->call('submitDeposit');

        $account = $member->regularSavingsAccount();
        $this->assertEquals(0, (float) $account->balance, 'Balance must not change until Treasurer confirms.');

        $intent = \App\Models\VoluntaryDepositIntent::where('member_id', $member->id)->first();
        $this->assertSame('pending', $intent->status);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(VoluntaryDeposits::class)
            ->call('confirm', $intent->id);

        $this->assertEquals(2000, (float) $account->fresh()->balance);
        $this->assertSame('confirmed', $intent->fresh()->status);
        $this->assertSame('voluntary_deposit', $account->fresh()->transactions()->first()->type);
    }

    public function test_voluntary_deposit_receipt_is_uploaded_and_downloadable_only_by_owner_and_treasurer(): void
    {
        $member = $this->makeActiveMember();
        $stranger = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        SavingsAccount::openFor($member, $regular);

        $receipt = UploadedFile::fake()->create('slip.pdf', 200, 'application/pdf');

        Livewire::actingAs($member->user)
            ->test(MySavings::class)
            ->call('openDepositModal', $member->regularSavingsAccount()->id)
            ->set('deposit_amount', '2000')
            ->set('deposit_receipt', $receipt)
            ->call('submitDeposit');

        $intent = \App\Models\VoluntaryDepositIntent::where('member_id', $member->id)->firstOrFail();
        $this->assertNotNull($intent->receipt_path);
        $this->assertSame('slip.pdf', $intent->receipt_original_filename);
        \Illuminate\Support\Facades\Storage::disk('local')->assertExists($intent->receipt_path);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        $this->actingAs($treasurer)->get(route('voluntary-deposits.receipt', $intent))->assertOk();
        $this->actingAs($member->user)->get(route('voluntary-deposits.receipt', $intent))->assertOk();
        $this->actingAs($stranger->user)->get(route('voluntary-deposits.receipt', $intent))->assertForbidden();
    }

    public function test_full_withdrawal_lifecycle_with_minimum_balance_enforcement(): void
    {
        $member = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        $account = SavingsAccount::openFor($member, $regular);
        $account->recordTransaction('contribution_deduction', 10000, 'Opening contribution', null);

        // Minimum balance rule seeded at 5000 for Regular Savings.
        Livewire::actingAs($member->user)
            ->test(RequestWithdrawal::class)
            ->set('savings_account_id', (string) $account->id)
            ->set('requested_amount', '8000') // would leave 2000, below the 5000 floor
            ->set('bank_name', 'First Bank')
            ->set('account_number', '0123456789')
            ->call('submit');

        $withdrawal = WithdrawalRequest::firstOrFail();
        $this->assertSame('pending', $withdrawal->status);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        // Treasurer tries to approve the full 8000 — must be blocked by the minimum-balance rule.
        Livewire::actingAs($treasurer)
            ->test(WithdrawalsReview::class)
            ->call('openReview', $withdrawal->id)
            ->set('approved_amount', '8000')
            ->call('approve');

        $this->assertSame('pending', $withdrawal->fresh()->status, 'Approval breaching the minimum balance must be blocked.');

        // Treasurer reduces to a compliant amount and endorses.
        Livewire::actingAs($treasurer)
            ->test(WithdrawalsReview::class)
            ->call('openReview', $withdrawal->id)
            ->set('approved_amount', '5000') // leaves exactly 5000
            ->call('approve');

        $withdrawal->refresh();
        $this->assertSame('treasurer_approved', $withdrawal->status);
        $this->assertEquals(5000, (float) $withdrawal->approved_amount);

        $chairman = User::factory()->create();
        $chairman->assignRole('chairman');

        Livewire::actingAs($chairman)
            ->test(WithdrawalsAuthorization::class)
            ->call('openAuthorize', $withdrawal->id)
            ->call('authorize_');

        $this->assertSame('chairman_authorized', $withdrawal->fresh()->status);

        Livewire::actingAs($treasurer)
            ->test(WithdrawalsReview::class)
            ->set('tab', 'disbursement')
            ->call('disburse', $withdrawal->id);

        $withdrawal->refresh();
        $this->assertSame('disbursed', $withdrawal->status);
        $this->assertEquals(5000, (float) $account->fresh()->balance);
        $this->assertSame('withdrawal', $account->fresh()->transactions()->first()->type);
    }

    public function test_a_recent_voluntary_deposit_cannot_be_withdrawn_within_the_lock_period(): void
    {
        $member = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        $account = SavingsAccount::openFor($member, $regular);
        $account->recordTransaction('contribution_deduction', 10000, 'Compulsory contribution', null);
        $account->recordTransaction('voluntary_deposit', 5000, 'Voluntary top-up', null);

        // Balance is 15000, but 5000 of it is a voluntary deposit made moments
        // ago — only the 10000 compulsory portion should be withdrawable.
        $this->assertEquals(5000, $account->fresh()->lockedVoluntaryDepositTotal());
        $this->assertEquals(10000, $account->fresh()->withdrawableBalance());

        Livewire::actingAs($member->user)
            ->test(RequestWithdrawal::class)
            ->set('savings_account_id', (string) $account->id)
            ->set('requested_amount', '12000') // exceeds the 10000 withdrawable ceiling
            ->set('bank_name', 'First Bank')
            ->set('account_number', '0123456789')
            ->call('submit')
            ->assertHasErrors(['requested_amount']);

        $this->assertSame(0, WithdrawalRequest::count(), 'The still-locked voluntary deposit must hard-block the request, not just warn.');

        Livewire::actingAs($member->user)
            ->test(RequestWithdrawal::class)
            ->set('savings_account_id', (string) $account->id)
            ->set('requested_amount', '10000') // exactly the compulsory (unlocked) portion
            ->set('bank_name', 'First Bank')
            ->set('account_number', '0123456789')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertSame(1, WithdrawalRequest::count(), 'Withdrawing only the unlocked compulsory portion must be allowed.');
    }

    public function test_a_voluntary_deposit_becomes_withdrawable_once_it_matures(): void
    {
        $member = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        $account = SavingsAccount::openFor($member, $regular);
        $account->recordTransaction('contribution_deduction', 10000, 'Compulsory contribution', null);
        $account->recordTransaction('voluntary_deposit', 5000, 'Voluntary top-up', null);

        // Backdate the voluntary deposit past the default 3-month hold.
        SavingsTransaction::where('savings_account_id', $account->id)
            ->where('type', 'voluntary_deposit')
            ->update(['posted_at' => now()->subMonths(4)]);

        $this->assertEquals(0, $account->fresh()->lockedVoluntaryDepositTotal());
        $this->assertEquals(15000, $account->fresh()->withdrawableBalance());

        Livewire::actingAs($member->user)
            ->test(RequestWithdrawal::class)
            ->set('savings_account_id', (string) $account->id)
            ->set('requested_amount', '15000')
            ->set('bank_name', 'First Bank')
            ->set('account_number', '0123456789')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertSame(1, WithdrawalRequest::count());
    }

    public function test_complete_withdrawal_excludes_locked_voluntary_deposits(): void
    {
        $member = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        $account = SavingsAccount::openFor($member, $regular);
        $account->recordTransaction('contribution_deduction', 20000, 'Compulsory contribution', null);
        $account->recordTransaction('voluntary_deposit', 5000, 'Voluntary top-up', null);

        // Balance 25000, minimum balance floor seeded at 5000, 5000 voluntary-locked
        // => payable = 25000 - 5000 - 5000 = 15000.
        Livewire::actingAs($member->user)
            ->test(RequestCompleteWithdrawal::class)
            ->set('savings_account_id', (string) $account->id)
            ->set('bank_name', 'First Bank')
            ->set('account_number', '0123456789')
            ->set('acknowledge', true)
            ->call('submit');

        $withdrawal = WithdrawalRequest::firstOrFail();
        $this->assertEquals(15000, (float) $withdrawal->requested_amount);
    }

    public function test_deposit_modal_and_confirmation_message_disclose_the_lock_rule(): void
    {
        $member = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        SavingsAccount::openFor($member, $regular);

        Livewire::actingAs($member->user)
            ->test(MySavings::class)
            ->call('openDepositModal', $member->regularSavingsAccount()->id)
            ->assertSee('must remain in your account')
            ->assertSee('3 months')
            ->set('deposit_amount', '2000')
            ->call('submitDeposit')
            ->assertSee('at least 3 months');
    }

    public function test_treasurer_can_configure_the_voluntary_deposit_lock_period(): void
    {
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(WithdrawalConditionsManager::class)
            ->set('voluntary_deposit_lock_months', '6')
            ->call('saveVoluntaryDepositLockMonths')
            ->assertHasNoErrors();

        $this->assertEquals(6, (int) Setting::get('voluntary_deposit_lock_months'));

        $member = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        $account = SavingsAccount::openFor($member, $regular);
        $account->recordTransaction('voluntary_deposit', 3000, 'Voluntary top-up', null);

        // 4 months old: mature under the old 3-month rule, still locked under the new 6-month rule.
        SavingsTransaction::where('savings_account_id', $account->id)->update(['posted_at' => now()->subMonths(4)]);

        $this->assertEquals(3000, $account->fresh()->lockedVoluntaryDepositTotal());
    }

    public function test_committed_but_undisbursed_withdrawals_reduce_available_balance_for_new_requests(): void
    {
        $member = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        $account = SavingsAccount::openFor($member, $regular);
        $account->recordTransaction('contribution_deduction', 10000, 'Opening contribution', null);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');
        $chairman = User::factory()->create();
        $chairman->assignRole('chairman');

        // First withdrawal: 4000, leaves 6000 — comfortably above the 5000 floor.
        $first = WithdrawalRequest::create([
            'member_id' => $member->id,
            'savings_account_id' => $account->id,
            'requested_amount' => 4000,
            'bank_name' => 'First Bank',
            'account_number' => '0000000001',
            'account_name' => $member->full_name,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        Livewire::actingAs($treasurer)->test(WithdrawalsReview::class)
            ->call('openReview', $first->id)->set('approved_amount', '4000')->call('approve');
        $this->assertSame('treasurer_approved', $first->fresh()->status);

        // The account's raw balance hasn't moved yet — nothing is disbursed.
        $this->assertEquals(10000, (float) $account->fresh()->balance);
        // But the committed amount is now tracked, and available balance reflects it.
        $this->assertEquals(4000, $account->fresh()->committedWithdrawalsTotal());
        $this->assertEquals(6000, $account->fresh()->availableBalance());

        // Second withdrawal: 4000 more. In isolation this looks fine against the
        // raw balance (10000 - 4000 = 6000 >= 5000), but combined with the first
        // commitment it would breach the floor (10000 - 4000 - 4000 = 2000 < 5000).
        $second = WithdrawalRequest::create([
            'member_id' => $member->id,
            'savings_account_id' => $account->id,
            'requested_amount' => 4000,
            'bank_name' => 'First Bank',
            'account_number' => '0000000002',
            'account_name' => $member->full_name,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        Livewire::actingAs($treasurer)->test(WithdrawalsReview::class)
            ->call('openReview', $second->id)->set('approved_amount', '4000')->call('approve');

        $this->assertSame('pending', $second->fresh()->status, 'Must be blocked: combined with the first commitment it breaches the minimum balance.');

        // The Chairman authorizing the first request must not double-count its own
        // already-committed amount against itself.
        Livewire::actingAs($chairman)->test(WithdrawalsAuthorization::class)
            ->call('openAuthorize', $first->id)->call('authorize_');

        $this->assertSame('chairman_authorized', $first->fresh()->status, 'Authorizing a request must not be blocked by its own prior commitment.');
    }

    public function test_reversal_workflow_corrects_a_wrongly_posted_transaction(): void
    {
        $member = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        $account = SavingsAccount::openFor($member, $regular);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');
        $chairman = User::factory()->create();
        $chairman->assignRole('chairman');

        // Wrongly posted a contribution of 6000 instead of 5000.
        $wrongTxn = $account->recordTransaction('contribution_deduction', 6000, 'Contribution for 2026-09', $treasurer->id);
        $this->assertEquals(6000, (float) $account->fresh()->balance);

        Livewire::actingAs($treasurer)
            ->test(ReversalsBoard::class)
            ->set('original_transaction_id', (string) $wrongTxn->id)
            ->set('reason', 'Posted 6000 instead of 5000, reversing to correct.')
            ->call('initiate');

        $reversal = \App\Models\ReversalRequest::firstOrFail();
        $this->assertSame('pending', $reversal->status);
        $this->assertEquals(6000, (float) $account->fresh()->balance, 'Balance must not move until Chairman authorizes.');

        Livewire::actingAs($chairman)
            ->test(ReversalsBoard::class)
            ->call('openAuthorize', $reversal->id)
            ->call('authorize_');

        $reversal->refresh();
        $this->assertSame('applied', $reversal->status);
        $this->assertEquals(0, (float) $account->fresh()->balance, 'The full original amount must be reversed out.');

        $correcting = $account->fresh()->transactions()->first();
        $this->assertSame('reversal_debit', $correcting->type);
        $this->assertSame($wrongTxn->id, $correcting->reversed_transaction_id);
        $this->assertTrue($wrongTxn->fresh()->isReversed());

        // Post the correct amount as a fresh transaction (per spec: reverse in full, then re-post correct).
        $account->fresh()->recordTransaction('contribution_deduction', 5000, 'Corrected contribution for 2026-09', $treasurer->id);
        $this->assertEquals(5000, (float) $account->fresh()->balance);
    }

    public function test_statement_pdf_downloads_even_though_account_no_contains_slashes(): void
    {
        // account_no is derived from membership_no, which is formatted like
        // FCET/CSL/<StaffID> — those slashes previously broke the download's
        // Content-Disposition header (Symfony rejects "/" in filenames).
        $member = $this->makeActiveMember(['staff_id' => 'FCET-6001', 'membership_no' => 'FCET/CSL/FCET-6001']);
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        $account = SavingsAccount::openFor($member, $regular);
        $this->assertStringContainsString('/', $account->account_no);

        $account->recordTransaction('contribution_deduction', 5000, 'Test contribution', null);

        $this->actingAs($member->user);

        $component = new SavingsStatement();
        $component->mount($account);
        $response = $component->downloadPdf();

        $disposition = $response->headers->get('Content-Disposition');
        $this->assertNotNull($disposition);
        $this->assertStringNotContainsString('FCET/CSL', $disposition, 'The raw slashed account number must not leak into the filename header.');
    }

    public function test_statement_pdf_template_uses_a_font_that_supports_the_naira_sign(): void
    {
        // dompdf's default PDF base fonts (Helvetica/Arial substitutes) have no
        // glyph for ₦ and silently render it as "?" — DejaVu Sans (bundled with
        // dompdf) does. This guards against that font declaration being dropped.
        $templateSource = file_get_contents(resource_path('views/pdf/savings-statement.blade.php'));

        $this->assertStringContainsString('DejaVu Sans', $templateSource);
    }

    public function test_complete_withdrawal_lifecycle_leaves_minimum_balance_and_suspends_member(): void
    {
        $member = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        $account = SavingsAccount::openFor($member, $regular);
        $account->recordTransaction('contribution_deduction', 20000, 'Opening contribution', null);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');
        $chairman = User::factory()->create();
        $chairman->assignRole('chairman');

        // Minimum balance rule seeded at 5000 — the payout must be capped at 15000.
        Livewire::actingAs($member->user)
            ->test(RequestCompleteWithdrawal::class)
            ->set('savings_account_id', (string) $account->id)
            ->set('bank_name', 'First Bank')
            ->set('account_number', '0123456789')
            ->set('acknowledge', true)
            ->call('submit');

        $withdrawal = WithdrawalRequest::firstOrFail();
        $this->assertSame('pending', $withdrawal->status);
        $this->assertTrue($withdrawal->isComplete());
        $this->assertEquals(15000, (float) $withdrawal->requested_amount, 'Complete withdrawal must be capped at balance minus the minimum-balance floor.');

        // A second complete withdrawal request must be blocked while one is in progress.
        try {
            Livewire::actingAs($member->user)->test(RequestCompleteWithdrawal::class);
            $this->fail('Expected a second complete withdrawal request to be blocked.');
        } catch (\Throwable $e) {
            // Expected.
        }

        Livewire::actingAs($treasurer)
            ->test(WithdrawalsReview::class)
            ->call('openReview', $withdrawal->id)
            ->call('approve');

        $this->assertSame('treasurer_approved', $withdrawal->fresh()->status);

        Livewire::actingAs($chairman)
            ->test(WithdrawalsAuthorization::class)
            ->call('openAuthorize', $withdrawal->id)
            ->call('authorize_');

        $this->assertSame('chairman_authorized', $withdrawal->fresh()->status);
        $this->assertSame('active', $member->fresh()->status, 'Member must remain active until funds are actually disbursed.');

        Livewire::actingAs($treasurer)
            ->test(WithdrawalsReview::class)
            ->set('tab', 'disbursement')
            ->call('disburse', $withdrawal->id);

        $withdrawal->refresh();
        $this->assertSame('disbursed', $withdrawal->status);
        $this->assertEquals(5000, (float) $account->fresh()->balance, 'The minimum balance must remain in the account.');
        $this->assertSame('suspended', $member->fresh()->status, 'The member must be suspended after a complete withdrawal is disbursed.');
    }

    public function test_deceased_member_disbursement_to_next_of_kin_skips_treasurer_review_stage(): void
    {
        $member = $this->makeActiveMember();
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        $account = SavingsAccount::openFor($member, $regular);
        $account->recordTransaction('contribution_deduction', 30000, 'Opening contribution', null);

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');
        $member->transitionTo('deceased', $superAdmin->id, 'Reported deceased.');

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');
        $chairman = User::factory()->create();
        $chairman->assignRole('chairman');

        Livewire::actingAs($treasurer)
            ->test(InitiateDeceasedDisbursement::class, ['member' => $member])
            ->set('savings_account_id', (string) $account->id)
            ->set('bank_name', 'Zenith Bank')
            ->set('account_number', '9988776655')
            ->set('account_name', 'Next of Kin Name')
            ->call('submit');

        $withdrawal = WithdrawalRequest::firstOrFail();
        // Treasurer-initiated deceased disbursements start already endorsed —
        // there is no separate "review" step since the Treasurer set the terms.
        $this->assertSame('treasurer_approved', $withdrawal->status);
        $this->assertTrue($withdrawal->isComplete());
        $this->assertTrue($withdrawal->isForNextOfKin());
        $this->assertEquals(25000, (float) $withdrawal->approved_amount, 'Payout must respect the minimum-balance floor even for a deceased member.');
        $this->assertSame('Next of Kin Name', $withdrawal->account_name);

        Livewire::actingAs($chairman)
            ->test(WithdrawalsAuthorization::class)
            ->call('openAuthorize', $withdrawal->id)
            ->call('authorize_');

        $this->assertSame('chairman_authorized', $withdrawal->fresh()->status);

        Livewire::actingAs($treasurer)
            ->test(WithdrawalsReview::class)
            ->set('tab', 'disbursement')
            ->call('disburse', $withdrawal->id);

        $withdrawal->refresh();
        $this->assertSame('disbursed', $withdrawal->status);
        $this->assertEquals(5000, (float) $account->fresh()->balance);
        $this->assertSame('deceased', $member->fresh()->status, 'A deceased member\'s status must not be changed by disbursement.');
    }
}
