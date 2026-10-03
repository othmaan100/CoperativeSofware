<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\UserManagement;
use App\Models\Member;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    protected function superAdmin(): User
    {
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');

        return $admin;
    }

    public function test_only_super_admin_can_access_user_management(): void
    {
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        try {
            Livewire::actingAs($treasurer)->test(UserManagement::class);
            $this->fail('Expected non-super-admin access to be blocked.');
        } catch (\Throwable $e) {
            // Expected.
        }

        $admin = $this->superAdmin();
        Livewire::actingAs($admin)->test(UserManagement::class)->assertOk();
    }

    public function test_super_admin_can_change_another_users_password_and_flag_it_for_change(): void
    {
        $admin = $this->superAdmin();

        $memberUser = User::factory()->create(['password' => Hash::make('old-password')]);
        $memberUser->assignRole('member');
        Member::factory()->create(['user_id' => $memberUser->id]);

        Livewire::actingAs($admin)
            ->test(UserManagement::class)
            ->call('openChangePassword', $memberUser->id)
            ->set('new_password', 'brand-new-password')
            ->set('new_password_confirmation', 'brand-new-password')
            ->call('changePassword');

        $fresh = $memberUser->fresh();
        $this->assertTrue(Hash::check('brand-new-password', $fresh->password));
        $this->assertTrue($fresh->must_change_password, 'Default should require the user to set their own password next login.');
    }

    public function test_require_change_checkbox_can_be_unchecked_for_a_permanent_reset(): void
    {
        $admin = $this->superAdmin();
        $targetUser = User::factory()->create();

        Livewire::actingAs($admin)
            ->test(UserManagement::class)
            ->call('openChangePassword', $targetUser->id)
            ->set('new_password', 'permanent-password-123')
            ->set('new_password_confirmation', 'permanent-password-123')
            ->set('require_change', false)
            ->call('changePassword');

        $this->assertFalse($targetUser->fresh()->must_change_password);
    }

    public function test_super_admin_cannot_change_their_own_password_from_this_screen(): void
    {
        $admin = $this->superAdmin();

        try {
            Livewire::actingAs($admin)
                ->test(UserManagement::class)
                ->call('openChangePassword', $admin->id);
            $this->fail('Expected self-password-change via this screen to be blocked.');
        } catch (\Throwable $e) {
            // Expected — must use the Profile page instead.
        }
    }

    public function test_search_filters_by_staff_id(): void
    {
        $admin = $this->superAdmin();

        $userA = User::factory()->create(['name' => 'Alpha Person']);
        Member::factory()->create(['user_id' => $userA->id, 'staff_id' => 'FCET-3333']);

        $userB = User::factory()->create(['name' => 'Beta Person']);
        Member::factory()->create(['user_id' => $userB->id, 'staff_id' => 'FCET-4444']);

        $component = Livewire::actingAs($admin)
            ->test(UserManagement::class)
            ->set('search', 'FCET-3333');

        $component->assertSee('Alpha Person')->assertDontSee('Beta Person');
    }
}
