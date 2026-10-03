<?php

namespace App\Models;

use App\Support\Csv;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class MemberImportBatch extends Model
{
    public const REQUIRED_COLUMNS = [
        'staff_id', 'full_name', 'employment_status', 'preferred_monthly_contribution',
    ];

    public const OPTIONAL_COLUMNS = [
        'membership_no', 'membership_date', 'date_of_birth', 'gender', 'marital_status', 'home_address',
        'phone_1', 'phone_2', 'email', 'ippis_number', 'department', 'date_of_first_appointment',
        'rank_grade', 'approved_monthly_contribution', 'mode_of_deduction', 'current_savings_balance',
        'nok_name', 'nok_relationship', 'nok_phone', 'nok_address',
    ];
    protected $fillable = [
        'uploaded_by',
        'file_path',
        'total_records',
        'imported_count',
        'status',
        'rows',
        'imported_at',
    ];

    protected $casts = [
        'rows' => 'array',
        'imported_at' => 'datetime',
    ];

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function matchedRows(): array
    {
        return collect($this->rows ?? [])->where('matched', true)->all();
    }

    public function flaggedRows(): array
    {
        return collect($this->rows ?? [])->where('matched', false)->all();
    }

    /**
     * Parse and validate every row of an uploaded CSV, returning the same
     * matched/flagged row-array shape used elsewhere (contribution batches),
     * without touching the database beyond read-only uniqueness checks.
     */
    public static function parseAndValidate(string $fullPath): array
    {
        $rows = [];
        $seenStaffIds = [];
        $seenEmails = [];
        $seenMembershipNos = [];

        $handle = fopen($fullPath, 'r');
        $header = Csv::readHeader($handle);
        $columnIndex = array_flip($header);

        while (($line = fgetcsv($handle)) !== false) {
            if (count(array_filter($line, fn ($v) => trim((string) $v) !== '')) === 0) {
                continue; // skip blank lines
            }

            $get = fn (string $column) => isset($columnIndex[$column], $line[$columnIndex[$column]])
                ? trim((string) $line[$columnIndex[$column]])
                : '';

            $dates = [];
            foreach (['membership_date', 'date_of_birth', 'date_of_first_appointment'] as $dateColumn) {
                $raw = $get($dateColumn);
                $dates[$dateColumn] = ['raw' => $raw, 'value' => $raw === '' ? null : Csv::parseDate($raw)];
            }

            $data = [
                'staff_id' => $get('staff_id'),
                'membership_no' => $get('membership_no') ?: null,
                'membership_date' => $dates['membership_date']['value'],
                'full_name' => $get('full_name'),
                'date_of_birth' => $dates['date_of_birth']['value'],
                'gender' => $get('gender') !== '' ? strtolower($get('gender')) : null,
                'marital_status' => $get('marital_status') !== '' ? strtolower($get('marital_status')) : null,
                'home_address' => $get('home_address') ?: null,
                'phone_1' => $get('phone_1') ?: null,
                'phone_2' => $get('phone_2') ?: null,
                'email' => $get('email') !== '' ? strtolower($get('email')) : null,
                'ippis_number' => $get('ippis_number') ?: null,
                'department' => $get('department') ?: null,
                'date_of_first_appointment' => $dates['date_of_first_appointment']['value'],
                'employment_status' => strtolower($get('employment_status')),
                'rank_grade' => $get('rank_grade') ?: null,
                'preferred_monthly_contribution' => $get('preferred_monthly_contribution'),
                'approved_monthly_contribution' => $get('approved_monthly_contribution') ?: null,
                'mode_of_deduction' => $get('mode_of_deduction') ?: 'salary_deduction',
                'current_savings_balance' => $get('current_savings_balance') ?: '0',
                'nok_name' => $get('nok_name') ?: null,
                'nok_relationship' => $get('nok_relationship') ?: null,
                'nok_phone' => $get('nok_phone') ?: null,
                'nok_address' => $get('nok_address') ?: null,
            ];

            $errors = [];

            foreach (['staff_id', 'full_name'] as $required) {
                if ($data[$required] === '') {
                    $errors[] = ucwords(str_replace('_', ' ', $required)).' is required.';
                }
            }

            foreach ($dates as $dateColumn => $date) {
                if ($date['raw'] !== '' && $date['value'] === null) {
                    $errors[] = ucfirst(str_replace('_', ' ', $dateColumn))." \"{$date['raw']}\" is not a valid date (use DD/MM/YYYY or YYYY-MM-DD).";
                }
            }

            if ($data['gender'] !== null && ! in_array($data['gender'], ['male', 'female'], true)) {
                $errors[] = 'Gender must be male or female.';
            }

            if ($data['marital_status'] !== null && ! in_array($data['marital_status'], ['single', 'married', 'divorced', 'widowed'], true)) {
                $errors[] = 'Marital status must be single, married, divorced or widowed.';
            }

            if (! in_array($data['employment_status'], ['permanent', 'contract', 'casual'], true)) {
                $errors[] = 'Employment status must be permanent, contract or casual.';
            }

            if ($data['email'] !== null && ! filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email is invalid.';
            }

            if (! is_numeric($data['preferred_monthly_contribution']) || (float) $data['preferred_monthly_contribution'] <= 0) {
                $errors[] = 'Preferred monthly contribution must be a positive number.';
            }

            if ($data['approved_monthly_contribution'] !== null && ! is_numeric($data['approved_monthly_contribution'])) {
                $errors[] = 'Approved monthly contribution must be numeric.';
            }

            if (! is_numeric($data['current_savings_balance']) || (float) $data['current_savings_balance'] < 0) {
                $errors[] = 'Current savings balance must be zero or a positive number.';
            }

            if ($data['staff_id'] !== '') {
                if (isset($seenStaffIds[$data['staff_id']])) {
                    $errors[] = 'Duplicate Staff ID within this file.';
                } elseif (Member::query()->where('staff_id', $data['staff_id'])->exists()) {
                    $errors[] = 'Staff ID already exists in the system.';
                }
                $seenStaffIds[$data['staff_id']] = true;
            }

            if ($data['email'] !== null) {
                if (isset($seenEmails[$data['email']])) {
                    $errors[] = 'Duplicate email within this file.';
                } elseif (User::query()->where('email', $data['email'])->exists()) {
                    $errors[] = 'Email already has an account in the system.';
                }
                $seenEmails[$data['email']] = true;
            }

            if ($data['membership_no']) {
                if (isset($seenMembershipNos[$data['membership_no']])) {
                    $errors[] = 'Duplicate Membership No. within this file.';
                } elseif (Member::query()->where('membership_no', $data['membership_no'])->exists()) {
                    $errors[] = 'Membership No. already exists in the system.';
                }
                $seenMembershipNos[$data['membership_no']] = true;
            }

            $data['matched'] = empty($errors);
            $data['error'] = empty($errors) ? null : implode(' ', $errors);
            $rows[] = $data;
        }
        fclose($handle);

        return $rows;
    }

    /**
     * Create the User + Member + NextOfKin + Regular Savings account (with an
     * opening-balance transaction if one was supplied) for a single validated
     * row. Returns the created Member.
     */
    public static function importRow(array $row, int $importedBy): Member
    {
        $user = User::create([
            'name' => $row['full_name'],
            'email' => $row['email'] ?? self::placeholderEmail($row['staff_id']),
            'password' => Hash::make($row['staff_id']),
            'must_change_password' => true,
            'email_verified_at' => now(),
        ]);
        $user->assignRole('member');

        $approvedContribution = $row['approved_monthly_contribution'] !== null
            ? (float) $row['approved_monthly_contribution']
            : (float) $row['preferred_monthly_contribution'];

        $member = Member::create([
            'user_id' => $user->id,
            'application_no' => Member::generateApplicationNo(),
            'membership_no' => $row['membership_no'] ?: 'FCET/CSL/'.$row['staff_id'],
            'membership_date' => $row['membership_date'],
            'full_name' => $row['full_name'],
            'date_of_birth' => $row['date_of_birth'],
            'gender' => $row['gender'],
            'ippis_number' => $row['ippis_number'],
            'marital_status' => $row['marital_status'],
            'home_address' => $row['home_address'],
            'phone_1' => $row['phone_1'],
            'phone_2' => $row['phone_2'],
            'email' => $row['email'],
            'department' => $row['department'],
            'staff_id' => $row['staff_id'],
            'date_of_first_appointment' => $row['date_of_first_appointment'],
            'employment_status' => $row['employment_status'],
            'rank_grade' => $row['rank_grade'],
            'preferred_monthly_contribution' => $row['preferred_monthly_contribution'],
            'approved_monthly_contribution' => $approvedContribution,
            'mode_of_deduction' => $row['mode_of_deduction'] ?: 'salary_deduction',
            'member_category' => 'regular_staff',
            'declaration_accepted' => true,
            'declaration_signed_name' => $row['full_name'],
            'status' => 'active',
            'application_fee_paid' => true,
            'application_fee_paid_at' => now(),
            'application_fee_source' => 'legacy_import',
            'application_fee_marked_by' => $importedBy,
            'applied_at' => now(),
            'approved_by' => $importedBy,
            'approved_at' => now(),
        ]);

        NextOfKin::create([
            'member_id' => $member->id,
            'name' => $row['nok_name'],
            'relationship' => $row['nok_relationship'],
            'phone' => $row['nok_phone'],
            'address' => $row['nok_address'],
        ]);

        $member->statusHistory()->create([
            'from_status' => null,
            'to_status' => 'active',
            'changed_by' => $importedBy,
            'reason' => 'Migrated from manual/paper records.',
        ]);

        $member->logEvent('member_imported', ['staff_id' => $row['staff_id']], $importedBy);

        ActivityLog::record(
            action: 'member.imported',
            description: "Imported legacy member {$member->full_name} ({$row['staff_id']}).",
            subject: $member,
            properties: ['staff_id' => $row['staff_id']],
            causerId: $importedBy,
        );

        ApplicationFeePayment::recordLegacyImport(
            member: $member,
            amount: (float) Setting::get('application_form_fee', 5000),
            recordedBy: $importedBy,
        );

        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        if ($regular) {
            $account = SavingsAccount::openFor($member, $regular);

            $openingBalance = (float) $row['current_savings_balance'];
            if ($openingBalance > 0) {
                $account->recordTransaction(
                    type: 'opening_balance',
                    amount: $openingBalance,
                    description: 'Opening balance migrated from manual records',
                    postedBy: $importedBy,
                    reference: 'IMPORT-'.$row['staff_id'],
                );
            }
        }

        return $member;
    }

    /**
     * A deterministic, unique login email for a member whose CSV row didn't
     * supply one. Staff IDs are already unique and validated before this is
     * called, so this can never collide with a real address.
     */
    protected static function placeholderEmail(string $staffId): string
    {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $staffId));

        return trim($slug, '-').'@no-email.fcetpcoop.local';
    }
}
