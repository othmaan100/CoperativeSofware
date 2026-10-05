<?php

namespace Tests\Feature;

use App\Livewire\Reports\RegistrationFeeReports;
use App\Models\ApplicationFeePayment;
use App\Models\Member;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RegistrationFeeReportsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
    }

    protected function makeMemberWithPayment(string $staffId, string $source = 'paystack'): Member
    {
        $user = User::factory()->create();
        $user->assignRole('member');
        $member = Member::factory()->create(['user_id' => $user->id, 'staff_id' => $staffId]);

        ApplicationFeePayment::create(array_merge([
            'member_id' => $member->id,
            'reference' => 'FEE-'.$staffId,
            'amount' => 5000,
            'status' => 'success',
            'source' => $source,
            'initiated_at' => now(),
            'paid_at' => now(),
        ], [
            'admin_pct' => 20,
            'profit_pct' => 80,
            'admin_amount' => 1000,
            'profit_amount' => 4000,
        ]));

        return $member;
    }

    public function test_treasurer_and_chairman_can_view_the_report(): void
    {
        $this->makeMemberWithPayment('FCET-7101', 'paystack');
        $this->makeMemberWithPayment('FCET-7102', 'manual');

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        $component = Livewire::actingAs($treasurer)->test(RegistrationFeeReports::class);
        $component->assertSee('₦10,000.00'); // total collected
        $component->assertSee('₦2,000.00'); // total admin
        $component->assertSee('₦8,000.00'); // total profit

        $chairman = User::factory()->create();
        $chairman->assignRole('chairman');
        Livewire::actingAs($chairman)->test(RegistrationFeeReports::class)->assertSee('₦10,000.00');
    }

    public function test_a_member_cannot_view_the_report(): void
    {
        $member = User::factory()->create();
        $member->assignRole('member');

        try {
            Livewire::actingAs($member)->test(RegistrationFeeReports::class);
            $this->fail('Expected a member to be blocked from the registration fee report.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_only_chairman_can_edit_the_split_not_treasurer(): void
    {
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        try {
            Livewire::actingAs($treasurer)->test(RegistrationFeeReports::class)->call('openSettingsForm');
            $this->fail('Expected the Treasurer to be blocked from editing the fee split.');
        } catch (\Throwable $e) {
            // Expected.
        }

        $chairman = User::factory()->create();
        $chairman->assignRole('chairman');

        Livewire::actingAs($chairman)
            ->test(RegistrationFeeReports::class)
            ->call('openSettingsForm')
            ->set('admin_pct', '30')
            ->call('saveSettings');

        $this->assertEquals(30, (float) Setting::get('application_fee_admin_pct'));
        $this->assertEquals(70, (float) Setting::get('application_fee_profit_pct'));
    }

    public function test_chairman_can_change_the_registration_fee_for_new_applicants_only(): void
    {
        $chairman = User::factory()->create();
        $chairman->assignRole('chairman');

        $applicantUser = User::factory()->create();
        $applicantUser->assignRole('applicant');
        $applicant = Member::factory()->create(['user_id' => $applicantUser->id, 'status' => 'pending', 'application_fee_paid' => false]);
        $alreadyPaid = ApplicationFeePayment::recordManual($applicant, 5000, $chairman->id);

        Livewire::actingAs($chairman)
            ->test(RegistrationFeeReports::class)
            ->call('openSettingsForm')
            ->assertSet('fee_amount', '5000')
            ->set('fee_amount', '0')
            ->call('saveSettings')
            ->assertHasErrors('fee_amount')
            ->set('fee_amount', '7500')
            ->call('saveSettings')
            ->assertHasNoErrors()
            ->assertSee('₦7,500.00');

        $this->assertEquals(7500, ApplicationFeePayment::currentFee());
        $this->assertEquals(5000, (float) $alreadyPaid->fresh()->amount, 'A fee already paid must keep its original amount.');

        Livewire::actingAs($applicantUser)->test(\App\Livewire\Members\PayApplicationFee::class)
            ->assertSet('feeAmount', '7500');
    }
}
