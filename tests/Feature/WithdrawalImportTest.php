<?php

namespace Tests\Feature;

use App\Livewire\Treasurer\ContributionBatchShow;
use App\Livewire\Treasurer\WithdrawalImports;
use App\Livewire\Treasurer\WithdrawalImportShow;
use App\Models\ContributionBatch;
use App\Models\Member;
use App\Models\SavingsAccount;
use App\Models\SavingsProduct;
use App\Models\User;
use App\Models\WithdrawalImportBatch;
use App\Models\WithdrawalRequest;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SavingsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class WithdrawalImportTest extends TestCase
{
    use RefreshDatabase;

    protected User $treasurer;

    protected Member $member;

    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow('2026-10-06 09:00:00');

        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
        $this->seed(SavingsSeeder::class);

        $this->treasurer = User::factory()->create();
        $this->treasurer->assignRole('treasurer');

        $this->member = Member::factory()->create([
            'staff_id' => 'FCE500', 'full_name' => 'Hauwa Sani', 'status' => 'active', 'membership_date' => '2025-06-01',
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    protected function account(): SavingsAccount
    {
        return SavingsAccount::openFor($this->member, SavingsProduct::where('code', SavingsProduct::REGULAR)->first());
    }

    /** Post a ₦10,000 contribution batch for the period through the real screen. */
    protected function postContributions(string $period, string $staffId = 'FCE500'): void
    {
        $batch = ContributionBatch::create([
            'period' => $period, 'uploaded_by' => $this->treasurer->id, 'file_path' => 'x', 'total_amount' => 10000,
            'total_records' => 1, 'status' => 'validated',
            'rows' => [['staff_id' => $staffId, 'amount' => 10000, 'shares' => 0, 'member_id' => Member::where('staff_id', $staffId)->value('id'), 'matched' => true, 'error' => null]],
        ]);

        Livewire::actingAs($this->treasurer)->test(ContributionBatchShow::class, ['batch' => $batch])->call('post');
    }

    protected function upload(string $csv): WithdrawalImportBatch
    {
        Livewire::actingAs($this->treasurer)->test(WithdrawalImports::class)
            ->set('file', UploadedFile::fake()->createWithContent('withdrawals.csv', $csv))
            ->call('processUpload')
            ->assertHasNoErrors();

        return WithdrawalImportBatch::latest('id')->firstOrFail();
    }

    public function test_contributions_are_dated_to_their_period_even_when_posted_out_of_order(): void
    {
        $this->postContributions('2025-08');
        $this->postContributions('2025-07');

        $entries = $this->account()->transactions()->reorder()->orderBy('posted_at')->get();

        $this->assertSame(['2025-07-31', '2025-08-31'], $entries->map(fn ($t) => $t->posted_at->toDateString())->all());
        $this->assertEquals([10000, 20000], $entries->map(fn ($t) => (float) $t->balance_after)->all());
        $this->assertEquals(10000, $this->account()->balanceAsOf(Carbon::parse('2025-08-15')));
    }

    public function test_current_month_contributions_are_not_dated_in_the_future(): void
    {
        $this->postContributions('2026-10');

        $this->assertSame('2026-10-06', $this->account()->transactions()->first()->posted_at->toDateString());
    }

    public function test_withdrawals_are_recorded_on_their_dates_and_checked_against_the_balance_then(): void
    {
        foreach (['2025-06', '2025-07', '2025-08'] as $period) {
            $this->postContributions($period);
        }

        $batch = $this->upload(
            "\xEF\xBB\xBFstaff_id,amount,withdrawal_date,type,reference,bank_name,account_number,account_name,reason\n".
            "FCE500,25000,15/07/2025,,,,,,Too early\n".
            "FCE500,\"15,000\",05/08/2025,partial,RCPT-77,First Bank,3011122233,Hauwa Sani,School fees\n"
        );

        $this->assertCount(1, $batch->matchedRows());
        $flagged = array_values($batch->flaggedRows())[0];
        $this->assertSame(2, $flagged['line']);
        $this->assertStringContainsString('the balance on 15/07/2025 would only be ₦10,000.00', $flagged['error']);

        Livewire::actingAs($this->treasurer)->test(WithdrawalImportShow::class, ['batch' => $batch])
            ->assertSee('₦25,000.00')
            ->call('post');

        $this->assertSame('posted', $batch->fresh()->status);

        $request = WithdrawalRequest::sole();
        $this->assertTrue($request->is_legacy_import);
        $this->assertSame('disbursed', $request->status);
        $this->assertEquals(15000, (float) $request->approved_amount);
        $this->assertSame('2025-08-05', $request->disbursed_at->toDateString());
        $this->assertSame('First Bank', $request->bank_name);

        $account = $this->account();
        $entries = $account->transactions()->reorder()->orderBy('posted_at')->get();
        $this->assertSame(['contribution_deduction', 'contribution_deduction', 'withdrawal', 'contribution_deduction'], $entries->pluck('type')->all());
        $this->assertEquals([10000, 20000, 5000, 15000], $entries->map(fn ($t) => (float) $t->balance_after)->all());
        $this->assertSame('RCPT-77', $entries[2]->reference);
        $this->assertEquals(15000, (float) $account->balance);
        $this->assertEquals(5000, $account->balanceAsOf(Carbon::parse('2025-08-20')));
    }

    public function test_each_row_is_checked_and_problems_are_explained(): void
    {
        $this->postContributions('2025-06');
        Member::factory()->create(['staff_id' => 'FCE501', 'status' => 'pending']);

        $batch = $this->upload(
            "staff_id,amount,withdrawal_date,type\n".
            "NOPE,1000,01/07/2025,\n".
            "FCE501,1000,01/07/2025,\n".
            "FCE500,abc,01/07/2025,\n".
            "FCE500,1000,31/02/2025,\n".
            "FCE500,1000,01/01/2027,\n".
            "FCE500,1000,15/05/2025,\n".
            "FCE500,1000,01/07/2025,everything\n".
            "FCE500,1000,01/07/2025,complete\n".
            "FCE500,1000,2025-07-01,\n"
        );

        $errors = collect($batch->rows)->pluck('error', 'line')->all();
        $this->assertSame('No member found for this Staff ID.', $errors[2]);
        $this->assertSame('No member found for this Staff ID.', $errors[3]);
        $this->assertSame('Amount must be a positive number.', $errors[4]);
        $this->assertStringContainsString('"31/02/2025" is not a valid date', $errors[5]);
        $this->assertSame('Withdrawal date cannot be in the future.', $errors[6]);
        $this->assertSame('Withdrawal date is before the member joined (01/06/2025).', $errors[7]);
        $this->assertSame('Type must be "partial" or "complete".', $errors[8]);
        $this->assertNull($errors[9]);
        $this->assertSame('Same member, date and amount as line 9.', $errors[10]);
    }

    public function test_a_file_without_the_required_columns_is_rejected(): void
    {
        Livewire::actingAs($this->treasurer)->test(WithdrawalImports::class)
            ->set('file', UploadedFile::fake()->createWithContent('w.csv', "staff_id,amount\nFCE500,100\n"))
            ->call('processUpload')
            ->assertHasErrors(['file']);

        $this->assertSame(0, WithdrawalImportBatch::count());
    }

    public function test_the_same_withdrawal_cannot_be_imported_twice(): void
    {
        $this->postContributions('2025-06');
        $csv = "staff_id,amount,withdrawal_date\nFCE500,4000,01/07/2025\n";

        $first = $this->upload($csv);
        $first->post($this->treasurer->id);

        $second = $this->upload($csv);
        $this->assertSame('This withdrawal has already been imported.', array_values($second->flaggedRows())[0]['error']);
    }

    public function test_rows_flagged_for_low_savings_pass_after_the_missing_contributions_are_posted(): void
    {
        $this->postContributions('2025-06');
        $batch = $this->upload("staff_id,amount,withdrawal_date\nFCE500,15000,10/08/2025\n");
        $this->assertCount(0, $batch->matchedRows());

        $this->postContributions('2025-07');

        Livewire::actingAs($this->treasurer)->test(WithdrawalImportShow::class, ['batch' => $batch])
            ->call('recheck')
            ->call('post');

        $this->assertEquals(5000, (float) $this->account()->balance);
    }

    public function test_posting_stops_if_the_savings_records_changed_since_upload(): void
    {
        $this->postContributions('2025-06');
        $batch = $this->upload("staff_id,amount,withdrawal_date\nFCE500,8000,01/07/2025\n");
        $this->assertCount(1, $batch->matchedRows());

        $this->account()->recordTransaction(type: 'withdrawal', amount: 5000, description: 'Paid out', postedBy: $this->treasurer->id, postedAt: Carbon::parse('2025-06-30 18:00'));

        Livewire::actingAs($this->treasurer)->test(WithdrawalImportShow::class, ['batch' => $batch])
            ->call('post')
            ->assertSee('no longer pass the checks');

        $this->assertSame('validated', $batch->fresh()->status);
        $this->assertSame(0, WithdrawalRequest::count());
    }

    public function test_legacy_dating_command_moves_old_imports_to_their_real_dates(): void
    {
        // Records imported before entries were dated: all stamped today.
        $account = $this->account();
        $account->recordTransaction(type: 'opening_balance', amount: 5000, description: 'Opening balance migrated from manual records', postedBy: null, reference: 'IMPORT-FCE500');
        foreach (['2025-06', '2025-07'] as $period) {
            $batch = ContributionBatch::create(['period' => $period, 'uploaded_by' => $this->treasurer->id, 'file_path' => 'x', 'total_amount' => 10000, 'total_records' => 1, 'status' => 'posted', 'rows' => []]);
            $account->recordTransaction(type: 'contribution_deduction', amount: 10000, description: 'x', postedBy: null, sourceBatchId: $batch->id);
        }

        $this->artisan('savings:date-legacy-records')->expectsOutputToContain('Contributions to re-date: 2')->assertSuccessful();
        $this->assertSame('2026-10-06', $account->transactions()->first()->posted_at->toDateString(), 'A dry run changes nothing.');

        $this->artisan('savings:date-legacy-records --apply')->assertSuccessful();

        $entries = $account->transactions()->reorder()->orderBy('posted_at')->get();
        $this->assertSame(['2025-06-01', '2025-06-30', '2025-07-31'], $entries->map(fn ($t) => $t->posted_at->toDateString())->all());
        $this->assertEquals([5000, 15000, 25000], $entries->map(fn ($t) => (float) $t->balance_after)->all());
        $this->assertEquals(25000, (float) $account->fresh()->balance);
    }

    public function test_requires_treasurer_permission(): void
    {
        $user = User::factory()->create();
        $user->assignRole('member');

        Livewire::actingAs($user)->test(WithdrawalImports::class)->assertForbidden();
    }
}
