<?php

namespace Tests\Feature;

use App\Livewire\Admin\ActivityLogViewer;
use App\Livewire\Treasurer\PendingApplications;
use App\Models\ActivityLog;
use App\Models\Member;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
    }

    protected function makeUserWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    public function test_successful_login_is_recorded(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret123')]);

        $ok = Auth::attempt(['email' => $user->email, 'password' => 'secret123']);

        $this->assertTrue($ok);

        $this->assertSame(
            1,
            ActivityLog::where('action', 'auth.login')->count(),
            'A single login must record exactly one entry — Laravel\'s default event auto-discovery already wires app/Listeners/*::handle(), so an additional explicit Event::listen() in a service provider double-fires it.'
        );

        $log = ActivityLog::where('action', 'auth.login')->first();
        $this->assertNotNull($log);
        $this->assertSame($user->id, $log->causer_id);
        $this->assertSame($user->name, $log->causer_name);
        $this->assertSame($user->id, $log->subject_id);
    }

    public function test_logout_is_recorded(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Auth::logout();

        $log = ActivityLog::where('action', 'auth.logout')->first();
        $this->assertNotNull($log);
        $this->assertSame($user->id, $log->causer_id);
    }

    public function test_failed_login_is_recorded_without_the_password(): void
    {
        $user = User::factory()->create(['password' => bcrypt('correct-password')]);

        $ok = Auth::attempt(['email' => $user->email, 'password' => 'wrong-password']);

        $this->assertFalse($ok);

        $log = ActivityLog::where('action', 'auth.login_failed')->first();
        $this->assertNotNull($log);
        $this->assertSame($user->email, $log->properties['attempted_email']);
        $this->assertStringNotContainsString('wrong-password', json_encode($log->properties));
        $this->assertNull($log->causer_id, 'A failed attempt has no authenticated causer.');
    }

    public function test_record_snapshots_the_causer_and_links_the_subject(): void
    {
        $user = $this->makeUserWithRole('treasurer');
        $member = Member::factory()->create(['user_id' => User::factory()->create()->id]);

        $this->actingAs($user);

        $log = ActivityLog::record('member.approved', 'Test description', $member, ['foo' => 'bar']);

        $this->assertSame($user->id, $log->causer_id);
        $this->assertSame($user->name, $log->causer_name);
        $this->assertSame($user->email, $log->causer_email);
        $this->assertSame(Member::class, $log->subject_type);
        $this->assertSame($member->id, $log->subject_id);
        $this->assertSame(['foo' => 'bar'], $log->properties);
    }

    public function test_approving_an_application_is_recorded_in_the_activity_log(): void
    {
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

        $log = ActivityLog::where('action', 'member.approved')->first();
        $this->assertNotNull($log, 'Approving an application should write a member.approved entry.');
        $this->assertSame($treasurer->id, $log->causer_id);
        $this->assertSame($member->id, $log->subject_id);
    }

    public function test_only_auditor_and_super_admin_can_view_the_activity_log(): void
    {
        $auditor = $this->makeUserWithRole('auditor');
        $superAdmin = $this->makeUserWithRole('super_admin');
        $treasurer = $this->makeUserWithRole('treasurer');

        Livewire::actingAs($auditor)->test(ActivityLogViewer::class)->assertOk();
        Livewire::actingAs($superAdmin)->test(ActivityLogViewer::class)->assertOk();

        try {
            Livewire::actingAs($treasurer)->test(ActivityLogViewer::class);
            $this->fail('Expected the Treasurer to be blocked from the Activity Log.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_viewer_filters_by_module_and_search(): void
    {
        $auditor = $this->makeUserWithRole('auditor');
        $causer = $this->makeUserWithRole('treasurer');

        $this->actingAs($causer);
        ActivityLog::record('loan.disbursed', 'Disbursed loan LN-0001 for Jane Doe.', null, [], $causer->id);
        ActivityLog::record('member.approved', 'Approved application for John Smith.', null, [], $causer->id);

        $component = Livewire::actingAs($auditor)->test(ActivityLogViewer::class);
        $component->assertSee('Disbursed loan LN-0001')->assertSee('Approved application for John Smith');

        $component->set('module', 'loan');
        $component->assertSee('Disbursed loan LN-0001')->assertDontSee('Approved application for John Smith');

        $component->set('module', '');
        $component->set('search', 'Jane Doe');
        $component->assertSee('Disbursed loan LN-0001')->assertDontSee('Approved application for John Smith');
    }
}
