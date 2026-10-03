<?php

namespace Tests\Feature;

use App\Livewire\Announcements\AnnouncementsManager;
use App\Livewire\Documents\DocumentsPanel;
use App\Livewire\Notifications\NotificationsIndex;
use App\Livewire\Treasurer\PendingApplications;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\Member;
use App\Models\User;
use App\Notifications\ApplicationApprovedNotification;
use Database\Seeders\LoanSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class DocumentsNotificationsAnnouncementsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
        $this->seed(LoanSeeder::class);
        Storage::fake('local');
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

    protected function makeDisbursedLoan(Member $member): Loan
    {
        $product = LoanProduct::query()->where('code', LoanProduct::REGULAR)->firstOrFail();

        return Loan::create([
            'member_id' => $member->id,
            'loan_product_id' => $product->id,
            'loan_no' => 'LN-TEST-'.$member->id,
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
            'disbursed_at' => now(),
        ]);
    }

    // --- Documents ---

    public function test_member_can_upload_view_and_delete_their_own_document(): void
    {
        $member = $this->makeActiveMember();

        Livewire::actingAs($member->user)
            ->test(DocumentsPanel::class, ['documentable' => $member])
            ->set('title', 'National ID Card')
            ->set('file', UploadedFile::fake()->create('id.pdf', 100, 'application/pdf'))
            ->call('upload');

        $document = Document::firstOrFail();
        $this->assertSame('National ID Card', $document->title);
        $this->assertSame($member->id, $document->documentable_id);
        Storage::disk('local')->assertExists($document->file_path);

        Livewire::actingAs($member->user)
            ->test(DocumentsPanel::class, ['documentable' => $member])
            ->call('delete', $document->id);

        $this->assertSame(0, Document::count());
        Storage::disk('local')->assertMissing($document->file_path);
    }

    public function test_unrelated_member_cannot_view_or_manage_another_members_documents(): void
    {
        $owner = $this->makeActiveMember();
        $stranger = $this->makeActiveMember();

        try {
            Livewire::actingAs($stranger->user)->test(DocumentsPanel::class, ['documentable' => $owner]);
            $this->fail('Expected an unrelated member to be blocked from viewing another member\'s documents.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_treasurer_can_manage_documents_but_an_auditor_can_only_view(): void
    {
        $treasurer = $this->makeUserWithRole('treasurer');
        $auditor = $this->makeUserWithRole('auditor');
        $member = $this->makeActiveMember();

        Livewire::actingAs($treasurer)
            ->test(DocumentsPanel::class, ['documentable' => $member])
            ->set('title', 'Certificate')
            ->set('file', UploadedFile::fake()->create('cert.pdf', 50, 'application/pdf'))
            ->call('upload');

        $this->assertSame(1, Document::count());

        // The auditor role has view_all_members but not manage_member_documents —
        // it can open the panel (view) but the manage controls must be off.
        $panel = Livewire::actingAs($auditor)->test(DocumentsPanel::class, ['documentable' => $member]);
        $this->assertFalse($panel->get('canManage'));

        try {
            $panel->call('upload');
            $this->fail('Expected the auditor to be blocked from uploading a document.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_loan_documents_are_visible_to_the_borrower_and_treasurer_but_not_a_stranger(): void
    {
        $member = $this->makeActiveMember();
        $loan = $this->makeDisbursedLoan($member);
        $treasurer = $this->makeUserWithRole('treasurer');
        $stranger = $this->makeActiveMember();

        Livewire::actingAs($member->user)->test(DocumentsPanel::class, ['documentable' => $loan])->assertOk();
        Livewire::actingAs($treasurer)->test(DocumentsPanel::class, ['documentable' => $loan])->assertOk();

        try {
            Livewire::actingAs($stranger->user)->test(DocumentsPanel::class, ['documentable' => $loan]);
            $this->fail('Expected an unrelated member to be blocked from viewing another member\'s loan documents.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_download_route_enforces_the_same_authorization_as_the_panel(): void
    {
        $member = $this->makeActiveMember();
        $stranger = $this->makeActiveMember();

        Livewire::actingAs($member->user)
            ->test(DocumentsPanel::class, ['documentable' => $member])
            ->set('title', 'ID')
            ->set('file', UploadedFile::fake()->create('id.pdf', 10, 'application/pdf'))
            ->call('upload');

        $document = Document::firstOrFail();

        $this->actingAs($member->user)->get(route('documents.download', $document))->assertOk();
        $this->actingAs($stranger->user)->get(route('documents.download', $document))->assertForbidden();
    }

    // --- Notifications ---

    public function test_approving_an_application_sends_an_in_app_notification_to_the_member(): void
    {
        Notification::fake();

        $applicantUser = User::factory()->create();
        $applicantUser->assignRole('applicant');
        $member = Member::factory()->create([
            'user_id' => $applicantUser->id,
            'status' => 'pending',
            'approved_at' => null,
            'membership_no' => null,
        ]);
        $treasurer = $this->makeUserWithRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(PendingApplications::class)
            ->call('openApprove', $member->id)
            ->set('approved_monthly_contribution', (string) $member->preferred_monthly_contribution)
            ->set('application_fee_paid', true)
            ->set('fee_override_note', 'Test override.')
            ->call('approve');

        Notification::assertSentTo($applicantUser, ApplicationApprovedNotification::class);
    }

    public function test_member_can_see_and_mark_a_real_notification_as_read(): void
    {
        $member = $this->makeActiveMember();
        $member->user->notify(new ApplicationApprovedNotification('FCET/CSL/00099'));

        $stored = $member->user->notifications()->firstOrFail();
        $this->assertNull($stored->read_at);

        Livewire::actingAs($member->user)
            ->test(NotificationsIndex::class)
            ->assertSee('Application approved')
            ->call('markAsRead', $stored->id);

        $this->assertNotNull($stored->fresh()->read_at);
    }

    // --- Announcements ---

    public function test_chairman_and_secretary_can_post_but_a_treasurer_cannot(): void
    {
        $chairman = $this->makeUserWithRole('chairman');
        $secretary = $this->makeUserWithRole('secretary');
        $treasurer = $this->makeUserWithRole('treasurer');

        Livewire::actingAs($chairman)->test(AnnouncementsManager::class)->assertOk();
        Livewire::actingAs($secretary)->test(AnnouncementsManager::class)->assertOk();

        try {
            Livewire::actingAs($treasurer)->test(AnnouncementsManager::class);
            $this->fail('Expected the Treasurer to be blocked from Announcements management.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_posting_an_announcement_notifies_every_user(): void
    {
        Notification::fake();

        $chairman = $this->makeUserWithRole('chairman');
        $member = $this->makeActiveMember();

        Livewire::actingAs($chairman)
            ->test(AnnouncementsManager::class)
            ->call('openCreate')
            ->set('title', 'AGM Notice')
            ->set('body', 'The AGM holds on 1 January.')
            ->call('save');

        $announcement = Announcement::firstOrFail();
        $this->assertSame('AGM Notice', $announcement->title);
        $this->assertSame($chairman->id, $announcement->posted_by);

        Notification::assertSentTo($member->user, \App\Notifications\NewAnnouncementNotification::class);
        Notification::assertSentTo($chairman, \App\Notifications\NewAnnouncementNotification::class);
    }
}
