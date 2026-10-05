<?php

namespace Tests\Feature;

use App\Livewire\Reports\SavingsReports;
use App\Models\ContributionBatch;
use App\Models\Member;
use App\Models\SavingsAccount;
use App\Models\SavingsProduct;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SavingsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MemberContributionsReportTest extends TestCase
{
    use RefreshDatabase;

    protected User $treasurer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
        $this->seed(SavingsSeeder::class);

        $this->treasurer = User::factory()->create();
        $this->treasurer->assignRole('treasurer');
    }

    protected function contribute(Member $member, float $amount, string $period): void
    {
        $batch = ContributionBatch::create([
            'period' => $period, 'uploaded_by' => $this->treasurer->id, 'file_path' => 'x',
            'total_amount' => $amount, 'total_records' => 1, 'status' => 'posted', 'rows' => [],
        ]);

        $account = SavingsAccount::openFor($member, SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first());
        $account->recordTransaction(
            type: 'contribution_deduction',
            amount: $amount,
            description: "Monthly contribution for {$period}",
            postedBy: $this->treasurer->id,
            reference: "BATCH-{$batch->id}",
            sourceBatchId: $batch->id,
        );
    }

    public function test_lists_every_member_with_totals_and_skips_pending_applicants(): void
    {
        $amina = Member::factory()->create(['full_name' => 'Amina Bello', 'staff_id' => 'FCE1', 'status' => 'active']);
        $musa = Member::factory()->create(['full_name' => 'Musa Garba', 'staff_id' => 'FCE2', 'status' => 'active']);
        Member::factory()->create(['full_name' => 'Pending Person', 'staff_id' => 'FCE3', 'status' => 'pending']);

        $this->contribute($amina, 10000, '2025-06');
        $this->contribute($amina, 10000, '2025-07');

        Livewire::actingAs($this->treasurer)
            ->test(SavingsReports::class)
            ->assertSee("All Members' Contributions", false)
            ->assertSee('Amina Bello')
            ->assertSee('Musa Garba')
            ->assertDontSee('Pending Person')
            ->assertSee('Jul 2025')
            ->assertSee('₦20,000.00')
            ->set('contributionSearch', 'FCE2')
            ->assertViewHas('memberContributions', fn ($page) => $page->pluck('full_name')->all() === ['Musa Garba']);

        $this->assertNotNull($musa);
    }

    public function test_csv_export_includes_all_members_and_a_total_row(): void
    {
        $amina = Member::factory()->create(['full_name' => 'Amina Bello', 'staff_id' => 'FCE1', 'status' => 'active']);
        Member::factory()->create(['full_name' => 'Musa Garba', 'staff_id' => 'FCE2', 'status' => 'active']);
        $this->contribute($amina, 10000, '2025-06');
        $this->contribute($amina, 15000, '2025-07');

        $this->actingAs($this->treasurer);
        $component = new SavingsReports();
        $component->mount();

        ob_start();
        $component->exportCsv('member-contributions')->sendContent();
        $lines = array_values(array_filter(explode("\n", ob_get_clean())));

        $this->assertStringContainsString('Total Contributions', $lines[0]);
        $this->assertCount(4, $lines, 'Header + 2 members + total row.');
        $this->assertStringContainsString('Amina Bello', $lines[1]);
        $this->assertStringContainsString('25000.00', $lines[1]);
        $this->assertStringContainsString('"Jul 2025"', $lines[1]);
        $this->assertStringContainsString('TOTAL (2 members)', $lines[3]);
    }

    public function test_requires_savings_reports_permission(): void
    {
        $member = User::factory()->create();
        $member->assignRole('member');

        Livewire::actingAs($member)->test(SavingsReports::class)->assertForbidden();
    }
}
