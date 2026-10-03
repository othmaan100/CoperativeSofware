<?php

namespace Tests\Feature;

use App\Livewire\Chairman\WelfareSettings;
use App\Livewire\Reports\WelfareReports;
use App\Livewire\Treasurer\WelfareLevyBatches;
use App\Livewire\Treasurer\WelfareLevyBatchShow;
use App\Livewire\Welfare\ClaimShow;
use App\Livewire\Welfare\ClaimsIndex;
use App\Livewire\Welfare\InitiateClaim;
use App\Models\Member;
use App\Models\Setting;
use App\Models\User;
use App\Models\WelfareClaim;
use App\Models\WelfareFund;
use App\Models\WelfareLevyBatch;
use App\Notifications\WelfareClaimAuthorizationDecisionNotification;
use App\Notifications\WelfareClaimAwaitingAuthorizationNotification;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class WelfareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    protected function makeUserWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
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

    protected function makeDeceasedMember(): Member
    {
        return $this->makeActiveMember(['status' => 'deceased']);
    }

    public function test_chairman_can_set_welfare_levy_and_death_benefit_amounts(): void
    {
        $chairman = $this->makeUserWithRole('chairman');

        Livewire::actingAs($chairman)
            ->test(WelfareSettings::class)
            ->set('welfare_levy_amount', '500')
            ->set('death_benefit_amount', '150000')
            ->call('save');

        $this->assertEquals(500.0, (float) Setting::get('welfare_levy_amount'));
        $this->assertEquals(150000.0, (float) Setting::get('death_benefit_amount'));
    }

    public function test_treasurer_can_upload_and_post_a_welfare_levy_batch(): void
    {
        Setting::set('welfare_levy_amount', 500);
        $treasurer = $this->makeUserWithRole('treasurer');
        $member1 = $this->makeActiveMember(['staff_id' => 'FCET-1001']);
        $member2 = $this->makeActiveMember(['staff_id' => 'FCET-1002']);

        $csv = "staff_id\nFCET-1001\nFCET-1002\nFCET-9999\n";
        $file = UploadedFile::fake()->createWithContent('levy.csv', $csv);

        Livewire::actingAs($treasurer)
            ->test(WelfareLevyBatches::class)
            ->set('period', '2026-09')
            ->set('file', $file)
            ->call('processUpload');

        $batch = WelfareLevyBatch::firstOrFail();
        $this->assertSame('validated', $batch->status);
        $this->assertSame(3, $batch->total_records);
        $this->assertCount(1, $batch->flaggedRows(), 'The unmatched staff_id should be flagged.');
        $this->assertEquals(1000.0, (float) $batch->total_amount);

        Livewire::actingAs($treasurer)
            ->test(WelfareLevyBatchShow::class, ['batch' => $batch])
            ->call('post');

        $batch->refresh();
        $this->assertSame('posted', $batch->status);
        $this->assertSame(2, $batch->payments()->count());

        $fund = WelfareFund::singleton();
        $this->assertEquals(1000.0, (float) $fund->balance);
    }

    public function test_a_member_cannot_be_charged_the_welfare_levy_twice_in_the_same_period(): void
    {
        Setting::set('welfare_levy_amount', 500);
        $treasurer = $this->makeUserWithRole('treasurer');
        $member = $this->makeActiveMember(['staff_id' => 'FCET-2001']);

        $csv = "staff_id\nFCET-2001\n";
        $file = UploadedFile::fake()->createWithContent('levy.csv', $csv);

        Livewire::actingAs($treasurer)->test(WelfareLevyBatches::class)
            ->set('period', '2026-09')->set('file', $file)->call('processUpload');
        $batch = WelfareLevyBatch::firstOrFail();
        Livewire::actingAs($treasurer)->test(WelfareLevyBatchShow::class, ['batch' => $batch])->call('post');

        $file2 = UploadedFile::fake()->createWithContent('levy2.csv', $csv);
        Livewire::actingAs($treasurer)->test(WelfareLevyBatches::class)
            ->set('period', '2026-09')->set('file', $file2)->call('processUpload');

        $secondBatch = WelfareLevyBatch::where('id', '!=', $batch->id)->firstOrFail();
        $this->assertCount(1, $secondBatch->flaggedRows());
        $this->assertSame('Already recorded as paid for this period.', $secondBatch->flaggedRows()[0]['error']);
    }

    public function test_full_death_benefit_claim_lifecycle(): void
    {
        Notification::fake();
        Setting::set('death_benefit_amount', 100000);

        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');
        $member = $this->makeDeceasedMember();

        Livewire::actingAs($treasurer)
            ->test(InitiateClaim::class, ['member' => $member])
            ->set('date_of_death', now()->subDays(3)->toDateString())
            ->set('beneficiary_name', 'Jane Doe')
            ->set('beneficiary_relationship', 'Spouse')
            ->set('beneficiary_phone', '08012345678')
            ->set('bank_name', 'First Bank')
            ->set('account_number', '0123456789')
            ->set('account_name', 'Jane Doe')
            ->call('submit');

        $claim = WelfareClaim::firstOrFail();
        $this->assertStringStartsWith('WLF/', $claim->claim_no);
        $this->assertSame(WelfareClaim::STATUS_PENDING, $claim->status);
        $this->assertEquals(100000.0, (float) $claim->amount);
        Notification::assertSentTo($chairman, WelfareClaimAwaitingAuthorizationNotification::class);

        Livewire::actingAs($chairman)
            ->test(ClaimShow::class, ['claim' => $claim])
            ->call('authorizeClaim');

        $claim->refresh();
        $this->assertSame(WelfareClaim::STATUS_CHAIRMAN_AUTHORIZED, $claim->status);
        Notification::assertSentTo($treasurer, WelfareClaimAuthorizationDecisionNotification::class);

        Livewire::actingAs($treasurer)
            ->test(ClaimShow::class, ['claim' => $claim])
            ->set('paymentReference', 'CHQ-100')
            ->call('disburse');

        $claim->refresh();
        $this->assertSame(WelfareClaim::STATUS_DISBURSED, $claim->status);
        $this->assertSame($treasurer->id, $claim->disbursed_by);
        $this->assertSame('CHQ-100', $claim->payment_reference);

        $fund = WelfareFund::singleton();
        $this->assertEquals(-100000.0, (float) $fund->balance, 'Disbursing without any prior levy collection should be allowed and simply take the fund negative — a real-world signal for the Treasurer to reconcile, not a hard block.');
    }

    public function test_chairman_can_decline_a_claim_with_a_reason(): void
    {
        Notification::fake();
        Setting::set('death_benefit_amount', 100000);
        $treasurer = $this->makeUserWithRole('treasurer');
        $member = $this->makeDeceasedMember();

        Livewire::actingAs($treasurer)
            ->test(InitiateClaim::class, ['member' => $member])
            ->set('date_of_death', now()->toDateString())
            ->set('beneficiary_name', 'John Doe')
            ->set('beneficiary_relationship', 'Son')
            ->set('beneficiary_phone', '08000000000')
            ->set('bank_name', 'GTBank')
            ->set('account_number', '0000000000')
            ->set('account_name', 'John Doe')
            ->call('submit');

        $claim = WelfareClaim::firstOrFail();
        $chairman = $this->makeUserWithRole('chairman');

        Livewire::actingAs($chairman)
            ->test(ClaimShow::class, ['claim' => $claim])
            ->call('openDeclineForm')
            ->set('declineNote', 'Missing death certificate.')
            ->call('decline');

        $claim->refresh();
        $this->assertSame(WelfareClaim::STATUS_CHAIRMAN_DECLINED, $claim->status);
        $this->assertSame('Missing death certificate.', $claim->chairman_note);
        Notification::assertSentTo($treasurer, WelfareClaimAuthorizationDecisionNotification::class);
    }

    public function test_a_claim_cannot_be_raised_for_a_member_who_is_not_deceased(): void
    {
        $treasurer = $this->makeUserWithRole('treasurer');
        $member = $this->makeActiveMember();

        try {
            Livewire::actingAs($treasurer)->test(InitiateClaim::class, ['member' => $member]);
            $this->fail('Expected a claim to be blocked for a member who is not deceased.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_a_second_claim_cannot_be_raised_while_one_is_already_in_progress(): void
    {
        Setting::set('death_benefit_amount', 100000);
        $treasurer = $this->makeUserWithRole('treasurer');
        $member = $this->makeDeceasedMember();

        Livewire::actingAs($treasurer)
            ->test(InitiateClaim::class, ['member' => $member])
            ->set('date_of_death', now()->toDateString())
            ->set('beneficiary_name', 'A')
            ->set('beneficiary_relationship', 'Spouse')
            ->set('beneficiary_phone', '080')
            ->set('bank_name', 'Bank')
            ->set('account_number', '111')
            ->set('account_name', 'A')
            ->call('submit');

        try {
            Livewire::actingAs($treasurer)->test(InitiateClaim::class, ['member' => $member->fresh()]);
            $this->fail('Expected a duplicate in-progress claim to be blocked.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_only_authorized_roles_can_access_welfare_components(): void
    {
        $member = $this->makeUserWithRole('member');

        foreach ([WelfareSettings::class, WelfareLevyBatches::class, ClaimsIndex::class, WelfareReports::class] as $componentClass) {
            try {
                Livewire::actingAs($member)->test($componentClass);
                $this->fail("Expected a plain member to be blocked from {$componentClass}.");
            } catch (\Throwable $e) {
                // Expected.
            }
        }
    }

    public function test_welfare_reports_page_shows_correct_totals(): void
    {
        Notification::fake();
        Setting::set('welfare_levy_amount', 500);
        Setting::set('death_benefit_amount', 100000);

        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');
        $payingMember = $this->makeActiveMember(['staff_id' => 'FCET-3001']);
        $deceasedMember = $this->makeDeceasedMember();

        $csv = "staff_id\nFCET-3001\n";
        $file = UploadedFile::fake()->createWithContent('levy.csv', $csv);
        Livewire::actingAs($treasurer)->test(WelfareLevyBatches::class)
            ->set('period', '2026-09')->set('file', $file)->call('processUpload');
        $batch = WelfareLevyBatch::firstOrFail();
        Livewire::actingAs($treasurer)->test(WelfareLevyBatchShow::class, ['batch' => $batch])->call('post');

        Livewire::actingAs($treasurer)
            ->test(InitiateClaim::class, ['member' => $deceasedMember])
            ->set('date_of_death', now()->toDateString())
            ->set('beneficiary_name', 'A')
            ->set('beneficiary_relationship', 'Spouse')
            ->set('beneficiary_phone', '080')
            ->set('bank_name', 'Bank')
            ->set('account_number', '111')
            ->set('account_name', 'A')
            ->call('submit');
        $claim = WelfareClaim::firstOrFail();
        Livewire::actingAs($chairman)->test(ClaimShow::class, ['claim' => $claim])->call('authorizeClaim');
        Livewire::actingAs($treasurer)->test(ClaimShow::class, ['claim' => $claim->fresh()])->call('disburse');

        $auditor = $this->makeUserWithRole('auditor');
        Livewire::actingAs($auditor)
            ->test(WelfareReports::class)
            ->assertOk()
            ->assertSee('₦500.00')
            ->assertSee('₦100,000.00');

        $fund = WelfareFund::singleton();
        $this->assertEquals(-99500.0, (float) $fund->balance);
    }
}
