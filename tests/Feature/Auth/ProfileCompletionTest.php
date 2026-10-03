<?php

namespace Tests\Feature\Auth;

use App\Livewire\Members\CompleteProfile;
use App\Models\Member;
use App\Models\NextOfKin;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileCompletionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    protected function memberMissing(array $overrides = []): Member
    {
        $user = User::factory()->create();

        $member = Member::factory()->create(array_merge([
            'user_id' => $user->id,
            'phone_1' => null,
            'email' => null,
            'gender' => null,
            'date_of_birth' => null,
            'marital_status' => null,
            'home_address' => null,
        ], $overrides));

        NextOfKin::create(['member_id' => $member->id, 'name' => null, 'relationship' => null, 'phone' => null]);

        return $member;
    }

    public function test_a_normal_complete_member_is_never_redirected(): void
    {
        $member = Member::factory()->create(['user_id' => User::factory()->create()->id]);

        $this->actingAs($member->user)->get(route('dashboard'))->assertOk();
    }

    public function test_a_member_with_missing_fields_is_redirected_to_complete_profile(): void
    {
        $member = $this->memberMissing();

        $this->actingAs($member->user)->get(route('dashboard'))->assertRedirect(route('profile.complete'));

        // The complete-profile page itself must remain reachable.
        $this->get(route('profile.complete'))->assertOk();
    }

    public function test_a_member_with_an_incomplete_next_of_kin_row_is_redirected(): void
    {
        $member = Member::factory()->create(['user_id' => User::factory()->create()->id]);
        NextOfKin::create([
            'member_id' => $member->id,
            'name' => 'Musa Sule',
            'relationship' => null,
            'phone' => null,
        ]);

        $this->actingAs($member->user)->get(route('dashboard'))->assertRedirect(route('profile.complete'));
    }

    public function test_a_member_with_no_next_of_kin_row_at_all_is_not_redirected_for_that_reason(): void
    {
        // No NextOfKin row exists (e.g. a record that predates this feature).
        // Treated as "not applicable", not as a missing-field gap.
        $member = Member::factory()->create(['user_id' => User::factory()->create()->id]);

        $this->actingAs($member->user)->get(route('dashboard'))->assertOk();
    }

    public function test_super_admin_without_a_member_profile_is_never_redirected(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');

        $this->actingAs($admin)->get(route('dashboard'))->assertOk();
    }

    public function test_completing_the_form_fills_in_only_the_missing_fields_and_unlocks_the_app(): void
    {
        $member = $this->memberMissing();

        $component = Livewire::actingAs($member->user)->test(CompleteProfile::class);

        $this->assertEqualsCanonicalizing(
            ['phone_1', 'email', 'gender', 'date_of_birth', 'marital_status', 'home_address', 'nok_name', 'nok_relationship', 'nok_phone'],
            $component->get('missing')
        );

        $component->set('phone_1', '08011112222')
            ->set('email', 'new.email@example.com')
            ->set('gender', 'male')
            ->set('date_of_birth', '1990-01-01')
            ->set('marital_status', 'single')
            ->set('home_address', '1 Coop Close')
            ->set('nok_name', 'Ali Bello')
            ->set('nok_relationship', 'Brother')
            ->set('nok_phone', '08033334444')
            ->call('submit')
            ->assertRedirect(route('dashboard', absolute: false));

        $fresh = $member->fresh();
        $this->assertSame('08011112222', $fresh->phone_1);
        $this->assertSame('new.email@example.com', $fresh->email);
        $this->assertSame('male', $fresh->gender);
        $this->assertSame('single', $fresh->marital_status);
        $this->assertSame('1 Coop Close', $fresh->home_address);
        $this->assertSame('new.email@example.com', $fresh->user->fresh()->email);

        $nok = $fresh->nextOfKin()->first();
        $this->assertSame('Ali Bello', $nok->name);
        $this->assertSame('Brother', $nok->relationship);
        $this->assertSame('08033334444', $nok->phone);

        $this->assertTrue($fresh->hasCompleteProfile());
        $this->actingAs($fresh->user)->get(route('dashboard'))->assertOk();
    }

    public function test_cannot_claim_an_email_already_used_by_another_account(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);
        $member = $this->memberMissing();

        Livewire::actingAs($member->user)
            ->test(CompleteProfile::class)
            ->set('phone_1', '08011112222')
            ->set('email', 'taken@example.com')
            ->set('gender', 'male')
            ->set('date_of_birth', '1990-01-01')
            ->set('marital_status', 'single')
            ->set('home_address', '1 Coop Close')
            ->set('nok_name', 'Ali Bello')
            ->set('nok_relationship', 'Brother')
            ->set('nok_phone', '08033334444')
            ->call('submit')
            ->assertHasErrors('email');
    }

    public function test_direct_access_once_profile_is_already_complete_is_rejected(): void
    {
        $member = Member::factory()->create(['user_id' => User::factory()->create()->id]);

        Livewire::actingAs($member->user)
            ->test(CompleteProfile::class)
            ->assertStatus(404);
    }
}
