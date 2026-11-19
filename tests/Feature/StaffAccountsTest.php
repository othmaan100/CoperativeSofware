<?php

namespace Tests\Feature;

use App\Livewire\Members\StaffAccounts;
use App\Models\ActivityLog;
use App\Models\Member;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class StaffAccountsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    protected function userWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    protected function staffMember(string $staffId = 'FCET-1001', string $role = 'member'): Member
    {
        $user = User::factory()->create(['password' => Hash::make('old-password'), 'must_change_password' => false]);
        $user->assignRole($role);

        return Member::factory()->create(['user_id' => $user->id, 'staff_id' => $staffId]);
    }

    public function test_secretary_and_treasurer_can_open_the_page_but_members_cannot(): void
    {
        $member = $this->staffMember();

        foreach (['secretary', 'treasurer', 'super_admin'] as $role) {
            Livewire::actingAs($this->userWithRole($role))
                ->test(StaffAccounts::class)
                ->assertOk()
                ->assertSee($member->staff_id);
        }

        Livewire::actingAs($member->user)->test(StaffAccounts::class)->assertForbidden();
        Livewire::actingAs($this->userWithRole('chairman'))->test(StaffAccounts::class)->assertForbidden();
    }

    public function test_secretary_can_change_a_staff_id_and_the_member_logs_in_with_the_new_one(): void
    {
        $member = $this->staffMember('FCET-1001');
        $this->staffMember('FCET-2002');

        $component = Livewire::actingAs($this->userWithRole('secretary'))
            ->test(StaffAccounts::class)
            ->call('openStaffId', $member->id)
            ->assertSet('staff_id', 'FCET-1001');

        // Must be unique and have a reason.
        $component->set('staff_id', 'FCET-2002')->call('saveStaffId')
            ->assertHasErrors(['staff_id' => 'unique', 'staff_id_reason' => 'required']);
        $this->assertSame('FCET-1001', $member->fresh()->staff_id);

        $component->set('staff_id', ' FCET-1009 ')
            ->set('staff_id_reason', 'Typo when imported')
            ->call('saveStaffId')
            ->assertHasNoErrors();

        $fresh = $member->fresh();
        $this->assertSame('FCET-1009', $fresh->staff_id);
        $this->assertSame($member->membership_no, $fresh->membership_no);
        $this->assertDatabaseHas('activity_logs', ['action' => 'member.staff_id_updated']);

        $this->post('/logout');
        Livewire::test('pages.auth.login')
            ->set('form.login', 'FCET-1009')
            ->set('form.password', 'old-password')
            ->call('login')
            ->assertHasNoErrors();
        $this->assertAuthenticatedAs($member->user);
    }

    public function test_treasurer_can_reset_password_to_staff_id_or_a_temporary_one(): void
    {
        $member = $this->staffMember('FCET-1001');
        $treasurer = $this->userWithRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(StaffAccounts::class)
            ->call('openPassword', $member->id)
            ->call('resetPassword')
            ->assertHasNoErrors();

        $user = $member->user->fresh();
        $this->assertTrue(Hash::check('FCET-1001', $user->password));
        $this->assertTrue($user->must_change_password);
        $this->assertSame(1, ActivityLog::where('action', 'member.password_reset')->count());

        $component = Livewire::actingAs($treasurer)
            ->test(StaffAccounts::class)
            ->call('openPassword', $member->id)
            ->set('password_method', 'custom')
            ->set('new_password', 'short')
            ->set('new_password_confirmation', 'short')
            ->call('resetPassword')
            ->assertHasErrors(['new_password' => 'min']);

        $component->set('new_password', 'temporary-pass')
            ->set('new_password_confirmation', 'temporary-pass')
            ->call('resetPassword')
            ->assertHasNoErrors();

        $this->assertTrue(Hash::check('temporary-pass', $member->user->fresh()->password));
    }

    public function test_officials_and_own_account_are_off_limits_except_to_super_admin(): void
    {
        $secretary = $this->userWithRole('secretary');
        $chairmanMember = $this->staffMember('FCET-3003', 'chairman');
        $ownMember = Member::factory()->create(['user_id' => $secretary->id, 'staff_id' => 'FCET-4004']);

        Livewire::actingAs($secretary)
            ->test(StaffAccounts::class)
            ->assertSee('Official — Super Admin only')
            ->call('openPassword', $chairmanMember->id)
            ->assertForbidden();

        Livewire::actingAs($secretary)->test(StaffAccounts::class)
            ->call('openStaffId', $ownMember->id)
            ->assertForbidden();

        Livewire::actingAs($this->userWithRole('super_admin'))
            ->test(StaffAccounts::class)
            ->call('openPassword', $chairmanMember->id)
            ->call('resetPassword')
            ->assertHasNoErrors();

        $this->assertTrue(Hash::check('FCET-3003', $chairmanMember->user->fresh()->password));
    }
}
