<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\ForceChangePassword;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ForcePasswordChangeTest extends TestCase
{
    use RefreshDatabase;

    protected function memberWithStaffIdPassword(string $staffId = 'FCET-9001'): Member
    {
        $user = User::factory()->create([
            'password' => Hash::make($staffId),
            'must_change_password' => true,
        ]);

        return Member::factory()->create([
            'user_id' => $user->id,
            'staff_id' => $staffId,
        ]);
    }

    public function test_login_with_staff_id_as_password_redirects_to_force_change_page(): void
    {
        $member = $this->memberWithStaffIdPassword();

        $component = Volt::test('pages.auth.login')
            ->set('form.login', $member->staff_id)
            ->set('form.password', $member->staff_id);

        $component->call('login');

        $component->assertRedirect(route('dashboard', absolute: false));

        // The dashboard redirect itself gets intercepted by the middleware.
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('password.force-change'));
    }

    public function test_pre_existing_account_is_flagged_retroactively_on_login_if_password_still_equals_staff_id(): void
    {
        // Simulate an account created before this safeguard existed: password
        // equals Staff ID, but must_change_password was never set.
        $user = User::factory()->create([
            'password' => Hash::make('FCET-9002'),
            'must_change_password' => false,
        ]);
        $member = Member::factory()->create(['user_id' => $user->id, 'staff_id' => 'FCET-9002']);

        Volt::test('pages.auth.login')
            ->set('form.login', 'FCET-9002')
            ->set('form.password', 'FCET-9002')
            ->call('login');

        $this->assertTrue($user->fresh()->must_change_password, 'Login must retroactively flag an account whose password still equals its Staff ID.');
    }

    public function test_normal_login_is_not_flagged_or_redirected(): void
    {
        $user = User::factory()->create(['password' => Hash::make('a-real-password')]);

        Volt::test('pages.auth.login')
            ->set('form.login', $user->email)
            ->set('form.password', 'a-real-password')
            ->call('login')
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertFalse($user->fresh()->must_change_password);

        $this->get(route('dashboard'))->assertOk();
    }

    public function test_flagged_user_cannot_reach_other_pages_until_password_is_changed(): void
    {
        $member = $this->memberWithStaffIdPassword('FCET-9003');
        $this->actingAs($member->user);

        $this->get(route('dashboard'))->assertRedirect(route('password.force-change'));
        $this->get(route('my-profile'))->assertRedirect(route('password.force-change'));

        // But the force-change page itself must remain reachable.
        $this->get(route('password.force-change'))->assertOk();
    }

    public function test_retrying_with_a_valid_password_after_a_rejected_attempt_succeeds(): void
    {
        $member = $this->memberWithStaffIdPassword('FCET-9006');

        $component = Livewire::actingAs($member->user)->test(ForceChangePassword::class);

        $component->set('new_password', 'FCET-9006')
            ->set('new_password_confirmation', 'FCET-9006')
            ->call('submit')
            ->assertHasErrors('new_password');

        // Same component instance, now with a genuinely valid password.
        $component->set('new_password', 'ValidNewPass789')
            ->set('new_password_confirmation', 'ValidNewPass789')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertFalse($member->user->fresh()->must_change_password);
    }

    public function test_new_password_cannot_equal_the_staff_id(): void
    {
        $member = $this->memberWithStaffIdPassword('FCET-9004');

        Livewire::actingAs($member->user)
            ->test(ForceChangePassword::class)
            ->set('new_password', 'FCET-9004')
            ->set('new_password_confirmation', 'FCET-9004')
            ->call('submit')
            ->assertHasErrors('new_password');

        $this->assertTrue($member->user->fresh()->must_change_password, 'Flag must remain set when the new password is rejected.');
    }

    public function test_successful_password_change_clears_the_flag_and_unlocks_the_app(): void
    {
        $member = $this->memberWithStaffIdPassword('FCET-9005');

        Livewire::actingAs($member->user)
            ->test(ForceChangePassword::class)
            ->set('new_password', 'a-brand-new-password')
            ->set('new_password_confirmation', 'a-brand-new-password')
            ->call('submit')
            ->assertRedirect(route('dashboard', absolute: false));

        $freshUser = $member->user->fresh();
        $this->assertFalse($freshUser->must_change_password);
        $this->assertTrue(Hash::check('a-brand-new-password', $freshUser->password));

        $this->actingAs($freshUser)->get(route('dashboard'))->assertOk();
    }
}
