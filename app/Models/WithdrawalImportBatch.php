<?php

namespace App\Models;

use App\Support\Csv;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class WithdrawalImportBatch extends Model
{
    public const REQUIRED_COLUMNS = ['staff_id', 'amount', 'withdrawal_date'];

    public const TEMPLATE_COLUMNS = ['staff_id', 'amount', 'withdrawal_date', 'type', 'reference', 'bank_name', 'account_number', 'account_name', 'reason'];

    /** Imported withdrawals are recorded at midday, after that day's other entries. */
    public const POSTING_HOUR = 12;

    protected $fillable = [
        'uploaded_by',
        'file_path',
        'total_amount',
        'total_records',
        'status',
        'rows',
        'posted_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'rows' => 'array',
        'posted_at' => 'datetime',
    ];

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(WithdrawalRequest::class);
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
     * Read the CSV and check each row on its own (member, amount, date,
     * type). Throws if a required column is missing from the header.
     */
    public static function parseFile(string $fullPath): array
    {
        $handle = fopen($fullPath, 'r');
        $header = Csv::readHeader($handle);

        $missing = array_diff(self::REQUIRED_COLUMNS, $header);
        if ($missing) {
            fclose($handle);
            throw new RuntimeException('The file is missing the column(s): '.implode(', ', $missing).'.');
        }

        $rows = [];
        $lineNo = 1;

        while (($line = fgetcsv($handle)) !== false) {
            $lineNo++;
            $values = [];
            foreach ($header as $i => $column) {
                $values[$column] = trim((string) ($line[$i] ?? ''));
            }

            if (($values['staff_id'] ?? '') === '' && ($values['amount'] ?? '') === '') {
                continue;
            }

            $rows[] = self::parseRow($values, $lineNo);
        }
        fclose($handle);

        return $rows;
    }

    protected static function parseRow(array $values, int $lineNo): array
    {
        $staffId = $values['staff_id'] ?? '';
        $amount = str_replace(',', '', $values['amount'] ?? '');
        $rawDate = $values['withdrawal_date'] ?? '';
        $date = Csv::parseDate($rawDate);
        $type = strtolower($values['type'] ?? '') ?: WithdrawalRequest::TYPE_PARTIAL;

        $member = $staffId !== ''
            ? Member::query()->where('staff_id', $staffId)->where('status', '!=', 'pending')->first()
            : null;

        $error = match (true) {
            $staffId === '' => 'Staff ID is required.',
            ! $member => 'No member found for this Staff ID.',
            ! is_numeric($amount) || (float) $amount <= 0 => 'Amount must be a positive number.',
            $date === null => "Withdrawal date \"{$rawDate}\" is not a valid date (use DD/MM/YYYY or YYYY-MM-DD).",
            Carbon::parse($date)->isFuture() => 'Withdrawal date cannot be in the future.',
            $member->membership_date && Carbon::parse($date)->lt($member->membership_date) => 'Withdrawal date is before the member joined ('.$member->membership_date->format('d/m/Y').').',
            ! in_array($type, [WithdrawalRequest::TYPE_PARTIAL, WithdrawalRequest::TYPE_COMPLETE], true) => 'Type must be "partial" or "complete".',
            default => null,
        };

        return [
            'line' => $lineNo,
            'staff_id' => $staffId,
            'member_id' => $member?->id,
            'member_name' => $member?->full_name,
            'amount' => is_numeric($amount) ? round((float) $amount, 2) : null,
            'withdrawal_date' => $date,
            'type' => $type,
            'reference' => $values['reference'] ?? '',
            'bank_name' => $values['bank_name'] ?? '',
            'account_number' => $values['account_number'] ?? '',
            'account_name' => $values['account_name'] ?? '',
            'reason' => $values['reason'] ?? '',
            'matched' => $error === null,
            'error' => $error,
        ];
    }

    /**
     * Checks that need the ledger and the other rows: the same withdrawal
     * imported twice, and whether the member's Regular Savings could cover
     * each withdrawal on its date. The balance is replayed in date order with
     * the file's withdrawals slotted in, so a withdrawal is flagged if it
     * would leave the balance negative on its date or at any later point.
     */
    public static function checkAgainstLedger(array $rows): array
    {
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        $seen = [];

        foreach ($rows as $i => $row) {
            if (! $row['matched']) {
                continue;
            }

            $key = "{$row['member_id']}|{$row['withdrawal_date']}|{$row['amount']}";
            if (isset($seen[$key])) {
                $rows[$i] = self::flag($row, "Same member, date and amount as line {$seen[$key]}.");

                continue;
            }
            $seen[$key] = $row['line'];

            $alreadyImported = WithdrawalRequest::query()
                ->where('member_id', $row['member_id'])
                ->where('is_legacy_import', true)
                ->where('approved_amount', $row['amount'])
                ->whereDate('disbursed_at', $row['withdrawal_date'])
                ->exists();

            if ($alreadyImported) {
                $rows[$i] = self::flag($row, 'This withdrawal has already been imported.');
            }
        }

        $byMember = collect($rows)->filter(fn ($row) => $row['matched'])->groupBy('member_id', preserveKeys: true);

        foreach ($byMember as $memberId => $memberRows) {
            $account = $regular
                ? SavingsAccount::query()->where('member_id', $memberId)->where('savings_product_id', $regular->id)->first()
                : null;

            $ledger = $account
                ? $account->transactions()->reorder()->orderBy('posted_at')->orderBy('id')->get(['type', 'amount', 'posted_at'])
                    ->map(fn ($t) => [
                        'at' => $t->posted_at->getTimestamp(),
                        'change' => in_array($t->type, SavingsAccount::CREDIT_TYPES, true) ? (float) $t->amount : -(float) $t->amount,
                        'row' => null,
                    ])->all()
                : [];

            $pending = $memberRows->keys()->all();

            // Drop the withdrawal that first takes the balance below zero,
            // then replay again, until the rest all fit.
            while ($pending) {
                $events = $ledger;
                foreach ($pending as $i) {
                    $events[] = ['at' => self::postingTime($rows[$i]['withdrawal_date'])->getTimestamp(), 'change' => -$rows[$i]['amount'], 'row' => $i];
                }
                usort($events, fn ($a, $b) => $a['at'] <=> $b['at']);

                $balance = 0.0;
                $lastRow = null;
                $failedAt = null;
                foreach ($events as $event) {
                    $balance = round($balance + $event['change'], 2);
                    $lastRow = $event['row'] ?? $lastRow;
                    if ($balance < 0 && $lastRow !== null) {
                        $failedAt = $lastRow;
                        break;
                    }
                }

                if ($failedAt === null) {
                    break;
                }

                $available = self::balanceOn($ledger, $rows, $pending, $failedAt);
                $rows[$failedAt] = self::flag($rows[$failedAt], sprintf(
                    'Not enough savings: the balance on %s would only be ₦%s. Make sure contributions up to that date have been posted.',
                    Carbon::parse($rows[$failedAt]['withdrawal_date'])->format('d/m/Y'),
                    number_format($available, 2),
                ));
                $pending = array_values(array_diff($pending, [$failedAt]));
            }
        }

        return $rows;
    }

    /** The balance just before row $target's withdrawal, counting the other accepted withdrawals. */
    protected static function balanceOn(array $ledger, array $rows, array $pending, int $target): float
    {
        $cutoff = self::postingTime($rows[$target]['withdrawal_date'])->getTimestamp();
        $balance = collect($ledger)->where('at', '<=', $cutoff)->sum('change');

        foreach ($pending as $i) {
            if ($i !== $target && self::postingTime($rows[$i]['withdrawal_date'])->getTimestamp() <= $cutoff) {
                $balance -= $rows[$i]['amount'];
            }
        }

        return max(0, round($balance, 2));
    }

    /**
     * Run the ledger checks again on every row that passed the file checks,
     * including rows flagged earlier for low savings, e.g. after the missing
     * contribution batches have been posted.
     */
    public function recheck(): void
    {
        $rows = collect($this->rows)->map(fn ($row) => $row['member_id'] && ! self::hasFileError($row)
            ? array_merge($row, ['matched' => true, 'error' => null])
            : $row)->all();

        $rows = self::checkAgainstLedger($rows);
        $this->update(['rows' => $rows, 'total_amount' => collect($rows)->where('matched', true)->sum('amount')]);
    }

    /** Whether a row was flagged by parseRow() (its own content), not by the ledger checks. */
    protected static function hasFileError(array $row): bool
    {
        return $row['error'] !== null
            && ! str_starts_with($row['error'], 'Not enough savings')
            && ! str_starts_with($row['error'], 'Same member, date and amount')
            && $row['error'] !== 'This withdrawal has already been imported.';
    }

    protected static function flag(array $row, string $error): array
    {
        return array_merge($row, ['matched' => false, 'error' => $error]);
    }

    public static function postingTime(string $date): Carbon
    {
        return Carbon::parse($date)->setTime(self::POSTING_HOUR, 0);
    }

    /**
     * Record every matched row as a disbursed withdrawal and a savings debit
     * dated to the withdrawal date. The rows are checked against the ledger
     * again first, since contributions or other withdrawals may have been
     * posted since the upload; if that flags anything new, nothing is posted.
     */
    public function post(int $postedBy): int
    {
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
        if (! $regular) {
            throw new RuntimeException('The Regular Savings product is not set up, so withdrawals cannot be recorded.');
        }

        $wasMatched = collect($this->matchedRows())->pluck('line')->all();
        $rows = self::checkAgainstLedger($this->rows);
        $this->update(['rows' => $rows, 'total_amount' => collect($rows)->where('matched', true)->sum('amount')]);

        if (collect($rows)->where('matched', false)->whereIn('line', $wasMatched)->isNotEmpty()) {
            throw new RuntimeException('Some rows no longer pass the checks because the savings records have changed since the upload. Review the flagged rows, then post again.');
        }

        if (! $this->matchedRows()) {
            throw new RuntimeException('There are no valid rows to post.');
        }

        return DB::transaction(function () use ($regular, $postedBy) {
            $count = 0;

            foreach (collect($this->matchedRows())->sortBy('withdrawal_date') as $row) {
                $member = Member::findOrFail($row['member_id']);
                $account = SavingsAccount::openFor($member, $regular);
                $at = self::postingTime($row['withdrawal_date']);

                $request = WithdrawalRequest::create([
                    'member_id' => $member->id,
                    'savings_account_id' => $account->id,
                    'type' => $row['type'],
                    'beneficiary_type' => WithdrawalRequest::BENEFICIARY_MEMBER,
                    'initiated_by' => $postedBy,
                    'requested_amount' => $row['amount'],
                    'approved_amount' => $row['amount'],
                    'bank_name' => $row['bank_name'],
                    'account_number' => $row['account_number'],
                    'account_name' => $row['account_name'],
                    'reason' => $row['reason'] ?: null,
                    'status' => 'disbursed',
                    'is_legacy_import' => true,
                    'withdrawal_import_batch_id' => $this->id,
                    'treasurer_reviewed_by' => $postedBy,
                    'treasurer_reviewed_at' => $at,
                    'treasurer_note' => "Imported from manual records (withdrawal import #{$this->id}).",
                    'disbursed_by' => $postedBy,
                    'disbursed_at' => $at,
                    'requested_at' => $at,
                ]);

                $account->recordTransaction(
                    type: 'withdrawal',
                    amount: (float) $row['amount'],
                    description: 'Withdrawal (imported from manual records)',
                    postedBy: $postedBy,
                    reference: $row['reference'] !== '' ? $row['reference'] : "WD-{$request->id}",
                    withdrawalRequestId: $request->id,
                    postedAt: $at,
                );

                $count++;
            }

            $this->update(['status' => 'posted', 'posted_at' => now()]);

            return $count;
        });
    }
}
