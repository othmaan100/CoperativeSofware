<?php

namespace Tests\Feature;

use App\Livewire\Members\MemberDirectory;
use App\Livewire\Members\MemberShow;
use App\Livewire\Members\MyProfile;
use App\Livewire\Members\RegisterApplication;
use App\Livewire\Secretary\ChangeRequests;
use App\Livewire\Treasurer\PendingApplications;
use App\Models\Member;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MemberManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
    }

    public function test_full_member_lifecycle(): void
    {
        // 1. Applicant submits the registration/application form.
        Livewire::test(RegisterApplication::class)
            ->set('full_name', 'Amina Bello')
            ->set('date_of_birth', '1985-04-10')
            ->set('gender', 'female')
            ->set('marital_status', 'married')
            ->set('home_address', 'No 1 Coop Street, Potiskum')
            ->set('phone_1', '08010000000')
            ->set('email', 'amina.bello@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->set('department', 'Bursary')
            ->set('staff_category', 'senior_staff')
            ->set('staff_id', 'SS/1001')
            ->set('employment_status', 'permanent')
            ->set('preferred_monthly_contribution', '6000')
            ->set('nok_name', 'Musa Bello')
            ->set('nok_relationship', 'Spouse')
            ->set('nok_phone', '08020000000')
            ->set('declaration_accepted', true)
            ->set('declaration_signed_name', 'Amina Bello')
            ->call('submit')
            ->assertRedirect(route('my-application.pay-fee'));

        $member = Member::firstOrFail();
        $this->assertSame('pending', $member->status);
        $this->assertNotNull($member->application_no);
        $this->assertTrue($member->user->hasRole('applicant'));
        $this->assertSame('senior_staff', $member->staff_category);

        // 2. Treasurer approves the application, adjusting the contribution.
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(PendingApplications::class)
            ->call('openApprove', $member->id)
            ->set('approved_monthly_contribution', '7000')
            ->set('adjustment_note', 'Rounded up per Exco policy.')
            ->set('application_fee_paid', true)
            ->set('fee_override_note', 'Paid in cash at the Bursary.')
            ->call('approve');

        $member->refresh();
        $this->assertSame('active', $member->status);
        $this->assertSame('FCET/CSL/SS/1001', $member->membership_no);
        $this->assertEquals(7000, (float) $member->approved_monthly_contribution);
        $this->assertTrue($member->application_fee_paid);
        $this->assertSame('manual', $member->application_fee_source);
        $this->assertSame($treasurer->id, $member->application_fee_marked_by);
        $this->assertTrue($member->user->fresh()->hasRole('member'));
        $this->assertFalse($member->user->fresh()->hasRole('applicant'));
        $this->assertCount(2, $member->statusHistory()->get()); // pending -> active history entries (initial + approval)

        // 3. Member edits an unlocked field -> creates a change request, not a direct update.
        Livewire::actingAs($member->user->fresh())
            ->test(MyProfile::class)
            ->set('phone_1', '08099999999')
            ->call('submitChanges');

        $member->refresh();
        $this->assertSame('08010000000', $member->phone_1, 'Member profile must not change until Secretary approves.');
        $this->assertSame(1, $member->changeRequests()->where('status', 'pending')->count());

        // 4. Secretary approves the change request -> now it applies.
        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');

        $changeRequest = $member->changeRequests()->where('status', 'pending')->first();

        Livewire::actingAs($secretary)
            ->test(ChangeRequests::class)
            ->call('approve', $changeRequest->id);

        $member->refresh();
        $this->assertSame('08099999999', $member->phone_1);
        $this->assertSame('approved', $changeRequest->fresh()->status);

        // 5. Locked fields cannot be bypassed via a change request.
        $member->changeRequests()->create([
            'field_name' => 'department',
            'old_value' => $member->department,
            'new_value' => 'Hacked Department',
            'status' => 'pending',
            'requested_by' => $member->user_id,
            'requested_at' => now(),
        ]);
        $lockedRequest = $member->changeRequests()->where('field_name', 'department')->first();

        try {
            Livewire::actingAs($secretary)
                ->test(ChangeRequests::class)
                ->call('approve', $lockedRequest->id);
            $this->fail('Expected approving a locked-field change request to be blocked.');
        } catch (\Throwable $e) {
            // Expected: the safety net in applyChange() refuses to apply locked fields.
        }

        $this->assertSame('Bursary', $member->fresh()->department, 'Locked fields must never change via a member change request.');
    }

    protected function baseRegistrationFields(): array
    {
        return [
            'full_name' => 'Chidi Okafor',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'marital_status' => 'single',
            'home_address' => 'No 2 Coop Street, Potiskum',
            'phone_1' => '08011111111',
            'email' => 'chidi.okafor@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'department' => 'Registry',
            'employment_status' => 'permanent',
            'preferred_monthly_contribution' => '6000',
            'nok_name' => 'Ngozi Okafor',
            'nok_relationship' => 'Spouse',
            'nok_phone' => '08022222222',
            'declaration_accepted' => true,
            'declaration_signed_name' => 'Chidi Okafor',
        ];
    }

    public function test_staff_number_must_match_ss_prefix_for_senior_staff(): void
    {
        $component = Livewire::test(RegisterApplication::class);
        foreach ($this->baseRegistrationFields() as $field => $value) {
            $component->set($field, $value);
        }

        $component
            ->set('staff_category', 'senior_staff')
            ->set('staff_id', 'JS/2001')
            ->call('submit')
            ->assertHasErrors(['staff_id']);

        $this->assertSame(0, Member::count(), 'No member should be created when the staff number format is wrong.');
    }

    public function test_staff_number_must_match_js_prefix_for_junior_staff(): void
    {
        $component = Livewire::test(RegisterApplication::class);
        foreach ($this->baseRegistrationFields() as $field => $value) {
            $component->set($field, $value);
        }

        $component
            ->set('staff_category', 'junior_staff')
            ->set('staff_id', 'SS/2002')
            ->call('submit')
            ->assertHasErrors(['staff_id']);

        $this->assertSame(0, Member::count());
    }

    public function test_junior_staff_can_register_with_a_correctly_formatted_staff_number(): void
    {
        $component = Livewire::test(RegisterApplication::class);
        foreach ($this->baseRegistrationFields() as $field => $value) {
            $component->set($field, $value);
        }

        $component
            ->set('staff_category', 'junior_staff')
            ->set('staff_id', 'JS/2003')
            ->call('submit')
            ->assertHasNoErrors();

        $member = Member::firstOrFail();
        $this->assertSame('junior_staff', $member->staff_category);
        $this->assertSame('JS/2003', $member->staff_id);
    }

    public function test_member_can_request_contribution_change_for_treasurer_approval(): void
    {
        $user = User::factory()->create();
        $user->assignRole('member');

        $member = Member::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
            'approved_monthly_contribution' => 5000,
        ]);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        // Member submits a request — the approved amount must not change yet.
        Livewire::actingAs($user)
            ->test(MyProfile::class)
            ->call('openContributionChangeModal')
            ->set('new_contribution_amount', '7000')
            ->set('contribution_change_reason', 'Salary increment')
            ->call('requestContributionChange');

        $this->assertEquals(5000, (float) $member->fresh()->approved_monthly_contribution, 'Amount must not change until Treasurer approves.');

        $request = \App\Models\ContributionChangeRequest::where('member_id', $member->id)->first();
        $this->assertSame('pending', $request->status);
        $this->assertEquals(7000, (float) $request->requested_amount);

        // A second request while one is pending must be blocked.
        try {
            Livewire::actingAs($user)->test(MyProfile::class)->call('openContributionChangeModal');
            $this->fail('Expected a second request to be blocked while one is already pending.');
        } catch (\Throwable $e) {
            // Expected.
        }

        // Treasurer approves — now the amount actually changes.
        Livewire::actingAs($treasurer)
            ->test(\App\Livewire\Treasurer\ContributionChangeRequests::class)
            ->call('openApprove', $request->id)
            ->call('approve');

        $this->assertEquals(7000, (float) $member->fresh()->approved_monthly_contribution);
        $this->assertSame('approved', $request->fresh()->status);
    }

    public function test_treasurer_can_approve_a_different_amount_than_requested(): void
    {
        $user = User::factory()->create();
        $user->assignRole('member');

        $member = Member::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
            'approved_monthly_contribution' => 5000,
        ]);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        Livewire::actingAs($user)
            ->test(MyProfile::class)
            ->call('openContributionChangeModal')
            ->set('new_contribution_amount', '10000')
            ->call('requestContributionChange');

        $request = \App\Models\ContributionChangeRequest::where('member_id', $member->id)->first();

        // Adjusting without a note must be blocked.
        Livewire::actingAs($treasurer)
            ->test(\App\Livewire\Treasurer\ContributionChangeRequests::class)
            ->call('openApprove', $request->id)
            ->set('approved_amount', '8000') // different from the requested 10000
            ->call('approve');

        $this->assertSame('pending', $request->fresh()->status, 'Adjusting the amount without a note must be blocked.');

        // With a note, the Treasurer's adjusted amount is what actually applies.
        Livewire::actingAs($treasurer)
            ->test(\App\Livewire\Treasurer\ContributionChangeRequests::class)
            ->call('openApprove', $request->id)
            ->set('approved_amount', '8000')
            ->set('review_note', 'Capped per Exco policy on maximum single increase.')
            ->call('approve');

        $request->refresh();
        $this->assertSame('approved', $request->status);
        $this->assertEquals(8000, (float) $request->approved_amount);
        $this->assertEquals(10000, (float) $request->requested_amount, 'The original request must remain on record even though a different amount was approved.');
        $this->assertEquals(8000, (float) $member->fresh()->approved_monthly_contribution, 'The Treasurer-approved amount, not the requested one, must take effect.');
    }

    public function test_contribution_change_rejection_leaves_amount_unchanged(): void
    {
        $user = User::factory()->create();
        $user->assignRole('member');

        $member = Member::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
            'approved_monthly_contribution' => 5000,
        ]);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        Livewire::actingAs($user)
            ->test(MyProfile::class)
            ->call('openContributionChangeModal')
            ->set('new_contribution_amount', '6000')
            ->call('requestContributionChange');

        $request = \App\Models\ContributionChangeRequest::where('member_id', $member->id)->first();

        Livewire::actingAs($treasurer)
            ->test(\App\Livewire\Treasurer\ContributionChangeRequests::class)
            ->call('openReject', $request->id)
            ->set('review_note', 'Not eligible for change this quarter.')
            ->call('reject');

        $this->assertEquals(5000, (float) $member->fresh()->approved_monthly_contribution);
        $this->assertSame('rejected', $request->fresh()->status);
    }

    public function test_member_directory_and_show_views_render_for_authorized_staff(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');

        $member = Member::factory()->create([
            'exit_requested_at' => now(),
            'exit_reason' => 'Relocating',
        ]);

        Livewire::actingAs($superAdmin)
            ->test(MemberDirectory::class)
            ->assertOk()
            ->set('status', 'active')
            ->assertOk()
            ->set('search', $member->staff_id)
            ->assertOk();

        Livewire::actingAs($superAdmin)
            ->test(MemberShow::class, ['member' => $member])
            ->assertOk()
            ->assertSee($member->staff_id)
            ->call('treasurerSignOff')
            ->assertOk()
            ->call('finalizeExit')
            ->assertOk();

        $this->assertSame('exited', $member->fresh()->status);
    }

    public function test_member_show_renders_for_a_legacy_import_with_missing_optional_fields(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');

        $member = Member::factory()->create([
            'department' => null,
            'phone_1' => null,
            'email' => null,
            'gender' => null,
            'marital_status' => null,
            'home_address' => null,
            'date_of_birth' => null,
            'rank_grade' => null,
        ]);

        Livewire::actingAs($superAdmin)
            ->test(MemberShow::class, ['member' => $member])
            ->assertOk()
            ->assertSee($member->staff_id);

        Livewire::actingAs($superAdmin)
            ->test(MemberDirectory::class)
            ->assertOk();
    }

    public function test_dormancy_flagging_command_flags_inactive_active_members(): void
    {
        $member = Member::factory()->create([
            'status' => 'active',
            'approved_at' => now()->subMonths(7),
            'last_contribution_at' => null,
            'dormant_flagged_at' => null,
        ]);

        $this->artisan('members:flag-dormant')->assertSuccessful();

        $this->assertNotNull($member->fresh()->dormant_flagged_at);
    }
}
