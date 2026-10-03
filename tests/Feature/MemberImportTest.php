<?php

namespace Tests\Feature;

use App\Livewire\Treasurer\MemberImportShow;
use App\Livewire\Treasurer\MemberImports;
use App\Models\Member;
use App\Models\MemberImportBatch;
use App\Models\SavingsAccount;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SavingsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class MemberImportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
        $this->seed(SavingsSeeder::class);
    }

    protected function csvRow(array $overrides = []): array
    {
        return array_merge([
            'staff_id' => 'FCET-7001',
            'full_name' => 'Amina Sule',
            'date_of_birth' => '1980-05-01',
            'gender' => 'female',
            'marital_status' => 'married',
            'home_address' => 'Potiskum',
            'phone_1' => '08010000001',
            'phone_2' => '',
            'email' => 'amina.sule@example.com',
            'ippis_number' => '',
            'department' => 'Bursary',
            'date_of_first_appointment' => '2005-01-01',
            'employment_status' => 'permanent',
            'rank_grade' => 'Level 10',
            'preferred_monthly_contribution' => '6000',
            'approved_monthly_contribution' => '6000',
            'mode_of_deduction' => 'salary_deduction',
            'current_savings_balance' => '75000',
            'membership_no' => '',
            'membership_date' => '2015-06-01',
            'nok_name' => 'Musa Sule',
            'nok_relationship' => 'Spouse',
            'nok_phone' => '08020000001',
            'nok_address' => '',
        ], $overrides);
    }

    protected function toCsv(array $rows): string
    {
        $headers = array_keys($this->csvRow());
        $lines = [implode(',', $headers)];

        foreach ($rows as $row) {
            $lines[] = implode(',', array_map(fn ($v) => str_contains((string) $v, ',') ? '"'.$v.'"' : $v, array_values($row)));
        }

        return implode("\n", $lines)."\n";
    }

    protected function treasurer(): User
    {
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        return $treasurer;
    }

    public function test_valid_row_imports_a_fully_active_member_with_login_and_opening_balance(): void
    {
        $treasurer = $this->treasurer();
        $csv = $this->toCsv([$this->csvRow()]);
        $file = UploadedFile::fake()->createWithContent('members.csv', $csv);

        Livewire::actingAs($treasurer)
            ->test(MemberImports::class)
            ->set('file', $file)
            ->call('processUpload');

        $batch = MemberImportBatch::firstOrFail();
        $this->assertSame('validated', $batch->status);
        $this->assertSame(1, $batch->total_records);
        $this->assertCount(1, $batch->matchedRows());
        $this->assertCount(0, $batch->flaggedRows());

        Livewire::actingAs($treasurer)
            ->test(MemberImportShow::class, ['batch' => $batch])
            ->call('import');

        $batch->refresh();
        $this->assertSame('imported', $batch->status);
        $this->assertSame(1, $batch->imported_count);

        $member = Member::where('staff_id', 'FCET-7001')->firstOrFail();
        $this->assertSame('active', $member->status);
        $this->assertSame('FCET/CSL/FCET-7001', $member->membership_no);
        $this->assertSame('2015-06-01', $member->membership_date->format('Y-m-d'));
        $this->assertEquals(6000, (float) $member->approved_monthly_contribution);
        $this->assertNotNull($member->user_id);
        $this->assertTrue($member->user->hasRole('member'));
        $this->assertTrue(Hash::check('FCET-7001', $member->user->password), 'Default password must be the Staff ID.');

        $account = SavingsAccount::where('member_id', $member->id)->firstOrFail();
        $this->assertEquals(75000, (float) $account->balance);
        $this->assertSame('opening_balance', $account->transactions()->first()->type);

        $this->assertNotNull($member->nextOfKin()->first());
        $this->assertSame('Musa Sule', $member->nextOfKin()->first()->name);

        $this->assertTrue($member->application_fee_paid);
        $feePayment = \App\Models\ApplicationFeePayment::where('member_id', $member->id)->firstOrFail();
        $this->assertSame('legacy_import', $feePayment->source);
        $this->assertSame('success', $feePayment->status);
        $this->assertSame($treasurer->id, $feePayment->recorded_by);
        $this->assertEquals(1000, (float) $feePayment->admin_amount);
        $this->assertEquals(4000, (float) $feePayment->profit_amount);
    }

    public function test_invalid_and_duplicate_rows_are_flagged_without_blocking_the_batch(): void
    {
        $treasurer = $this->treasurer();

        $existing = Member::factory()->create(['staff_id' => 'FCET-7777']);

        $rows = [
            $this->csvRow(), // valid
            $this->csvRow(['staff_id' => 'FCET-7777', 'email' => 'someone-else@example.com']), // duplicate staff_id already in DB
            $this->csvRow(['staff_id' => 'FCET-7002', 'email' => 'amina.sule@example.com']), // duplicate email within batch
            $this->csvRow(['staff_id' => 'FCET-7003', 'gender' => 'other', 'email' => 'other@example.com']), // invalid gender
        ];

        $csv = $this->toCsv($rows);
        $file = UploadedFile::fake()->createWithContent('members.csv', $csv);

        Livewire::actingAs($treasurer)
            ->test(MemberImports::class)
            ->set('file', $file)
            ->call('processUpload');

        $batch = MemberImportBatch::firstOrFail();
        $this->assertSame(4, $batch->total_records);
        $this->assertCount(1, $batch->matchedRows());
        $this->assertCount(3, $batch->flaggedRows());

        Livewire::actingAs($treasurer)
            ->test(MemberImportShow::class, ['batch' => $batch])
            ->call('import');

        $this->assertSame(1, $batch->fresh()->imported_count);
        $this->assertSame(2, Member::count(), 'Only the pre-existing member and the one valid row should exist.');
    }

    public function test_row_with_blank_optional_personal_fields_still_imports_and_flags_profile_as_incomplete(): void
    {
        $treasurer = $this->treasurer();

        $row = $this->csvRow([
            'phone_1' => '', 'email' => '', 'gender' => '', 'marital_status' => '',
            'date_of_birth' => '', 'home_address' => '', 'department' => '', 'rank_grade' => '',
            'date_of_first_appointment' => '', 'nok_name' => '', 'nok_relationship' => '', 'nok_phone' => '',
        ]);

        $csv = $this->toCsv([$row]);
        $file = UploadedFile::fake()->createWithContent('members.csv', $csv);

        Livewire::actingAs($treasurer)
            ->test(MemberImports::class)
            ->set('file', $file)
            ->call('processUpload');

        $batch = MemberImportBatch::firstOrFail();
        $this->assertCount(1, $batch->matchedRows(), 'A row missing only the now-optional fields must still validate.');

        Livewire::actingAs($treasurer)
            ->test(MemberImportShow::class, ['batch' => $batch])
            ->call('import');

        $member = Member::where('staff_id', 'FCET-7001')->firstOrFail();
        $this->assertSame('active', $member->status);
        $this->assertNull($member->phone_1);
        $this->assertNull($member->email);
        $this->assertNull($member->gender);
        $this->assertNull($member->date_of_birth);
        $this->assertNull($member->marital_status);
        $this->assertNull($member->home_address);
        $this->assertNull($member->department);

        // A real, unique login email was still generated for the account.
        $this->assertNotNull($member->user->email);
        $this->assertStringEndsWith('@no-email.fcetpcoop.local', $member->user->email);

        $this->assertEqualsCanonicalizing(
            ['phone_1', 'email', 'gender', 'date_of_birth', 'marital_status', 'home_address', 'nok_name', 'nok_relationship', 'nok_phone'],
            $member->missingProfileFields()
        );
    }

    public function test_membership_date_is_optional_but_validated_when_given(): void
    {
        $treasurer = $this->treasurer();

        $rows = [
            $this->csvRow(['staff_id' => 'FCET-7005', 'email' => 'f7005@example.com', 'membership_date' => '']),
            $this->csvRow(['staff_id' => 'FCET-7006', 'email' => 'f7006@example.com', 'membership_date' => 'not-a-date']),
        ];
        $csv = $this->toCsv($rows);
        $file = UploadedFile::fake()->createWithContent('members.csv', $csv);

        Livewire::actingAs($treasurer)
            ->test(MemberImports::class)
            ->set('file', $file)
            ->call('processUpload');

        $batch = MemberImportBatch::firstOrFail();
        $this->assertCount(1, $batch->matchedRows(), 'A blank membership date must still validate.');
        $this->assertCount(1, $batch->flaggedRows(), 'An unparseable membership date must be flagged.');

        Livewire::actingAs($treasurer)
            ->test(MemberImportShow::class, ['batch' => $batch])
            ->call('import');

        $member = Member::where('staff_id', 'FCET-7005')->firstOrFail();
        $this->assertNull($member->membership_date);
        $this->assertNull(Member::where('staff_id', 'FCET-7006')->first(), 'The row with an invalid membership date must not be imported.');
    }

    public function test_staff_id_and_full_name_remain_required(): void
    {
        $treasurer = $this->treasurer();

        $rows = [
            $this->csvRow(['staff_id' => '']),
            $this->csvRow(['staff_id' => 'FCET-7004', 'full_name' => '']),
        ];

        $csv = $this->toCsv($rows);
        $file = UploadedFile::fake()->createWithContent('members.csv', $csv);

        Livewire::actingAs($treasurer)
            ->test(MemberImports::class)
            ->set('file', $file)
            ->call('processUpload');

        $batch = MemberImportBatch::firstOrFail();
        $this->assertCount(0, $batch->matchedRows());
        $this->assertCount(2, $batch->flaggedRows());
    }

    public function test_excel_utf8_csv_with_byte_order_mark_and_day_first_dates_imports_correctly(): void
    {
        $treasurer = $this->treasurer();

        $csv = "\xEF\xBB\xBF".$this->toCsv([
            $this->csvRow(['staff_id' => 'FCE100205', 'email' => 'f205@example.com', 'membership_date' => '01/07/2025', 'date_of_birth' => '15/03/1980']),
        ]);
        $file = UploadedFile::fake()->createWithContent('members.csv', $csv);

        Livewire::actingAs($treasurer)->test(MemberImports::class)->set('file', $file)->call('processUpload');

        $batch = MemberImportBatch::firstOrFail();
        $this->assertCount(1, $batch->matchedRows(), 'A UTF-8 byte-order mark must not hide the staff_id column.');

        Livewire::actingAs($treasurer)->test(MemberImportShow::class, ['batch' => $batch])->call('import');

        $member = Member::where('staff_id', 'FCE100205')->firstOrFail();
        $this->assertSame('2025-07-01', $member->membership_date->format('Y-m-d'), '01/07/2025 is 1 July, not 7 January.');
        $this->assertSame('1980-03-15', $member->date_of_birth->format('Y-m-d'));
    }

    public function test_impossible_dates_are_flagged(): void
    {
        $treasurer = $this->treasurer();
        $file = UploadedFile::fake()->createWithContent('members.csv', $this->toCsv([
            $this->csvRow(['membership_date' => '31/02/2025']),
        ]));

        Livewire::actingAs($treasurer)->test(MemberImports::class)->set('file', $file)->call('processUpload');

        $batch = MemberImportBatch::firstOrFail();
        $this->assertCount(1, $batch->flaggedRows());
        $this->assertStringContainsString('Membership date "31/02/2025" is not a valid date', $batch->flaggedRows()[0]['error']);
    }

    public function test_template_no_longer_includes_a_date_of_birth_column(): void
    {
        $this->actingAs($this->treasurer());

        $response = (new MemberImports())->downloadTemplate();
        ob_start();
        $response->sendContent();
        $content = ob_get_clean();
        $headerLine = strtok($content, "\n");

        $this->assertStringNotContainsString('date_of_birth', $headerLine);
        $this->assertStringContainsString('staff_id', $headerLine);
        $this->assertStringContainsString('membership_date', $headerLine);
    }

    public function test_import_requires_permission(): void
    {
        $member = User::factory()->create();
        $member->assignRole('member');

        try {
            Livewire::actingAs($member)->test(MemberImports::class);
            $this->fail('Expected non-treasurer access to be blocked.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }
}
