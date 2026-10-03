<?php

namespace App\Models;

use App\Support\Csv;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanImportBatch extends Model
{
    public const REQUIRED_COLUMNS = [
        'staff_id', 'loan_product', 'principal_amount', 'total_interest', 'tenure_months', 'disbursed_date',
    ];

    public const OPTIONAL_COLUMNS = ['amount_repaid'];

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
     * Parse and validate every row of an uploaded legacy-loan CSV. This is a
     * read-only pass (only uniqueness/lookup checks touch the database) —
     * the same matched/flagged row-array shape used by the member import.
     */
    public static function parseAndValidate(string $fullPath): array
    {
        $rows = [];

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

            $data = [
                'staff_id' => $get('staff_id'),
                'loan_product' => strtolower($get('loan_product')),
                'principal_amount' => $get('principal_amount'),
                'total_interest' => $get('total_interest'),
                'tenure_months' => $get('tenure_months'),
                'disbursed_date' => Csv::parseDate($get('disbursed_date')) ?? $get('disbursed_date'),
                'amount_repaid' => $get('amount_repaid') ?: '0',
            ];

            $errors = [];

            if ($data['staff_id'] === '') {
                $errors[] = 'Staff ID is required.';
            } elseif (! Member::query()->where('staff_id', $data['staff_id'])->exists()) {
                $errors[] = 'No member found for this Staff ID.';
            }

            $product = LoanProduct::query()->where('code', $data['loan_product'])->where('is_active', true)->first();
            if (! $product) {
                $errors[] = 'Loan product must be a valid, active product code (e.g. regular, emergency).';
            }

            if (! is_numeric($data['principal_amount']) || (float) $data['principal_amount'] <= 0) {
                $errors[] = 'Principal amount must be a positive number.';
            }

            if (! is_numeric($data['total_interest']) || (float) $data['total_interest'] < 0) {
                $errors[] = 'Total interest must be zero or a positive number.';
            }

            if (! ctype_digit($data['tenure_months']) || (int) $data['tenure_months'] <= 0) {
                $errors[] = 'Tenure (months) must be a positive whole number.';
            }

            if (Csv::parseDate($data['disbursed_date']) === null) {
                $errors[] = 'Disbursed date is missing or invalid (use DD/MM/YYYY or YYYY-MM-DD).';
            }

            if (! is_numeric($data['amount_repaid']) || (float) $data['amount_repaid'] < 0) {
                $errors[] = 'Amount repaid must be zero or a positive number.';
            }

            $data['matched'] = empty($errors);
            $data['error'] = empty($errors) ? null : implode(' ', $errors);
            $rows[] = $data;
        }
        fclose($handle);

        return $rows;
    }

    /**
     * Create a single legacy loan record (with its repayment schedule,
     * back-filled as already-paid up to the supplied amount_repaid) from one
     * validated import row. Lands directly as active/closed — never
     * re-enters the application -> approval -> disbursement workflow.
     */
    public static function importRow(array $row, int $importedBy): Loan
    {
        $member = Member::query()->where('staff_id', $row['staff_id'])->firstOrFail();
        $product = LoanProduct::query()->where('code', $row['loan_product'])->firstOrFail();

        $principal = (float) $row['principal_amount'];
        $totalInterest = (float) $row['total_interest'];
        $tenureMonths = (int) $row['tenure_months'];
        $amountRepaid = (float) $row['amount_repaid'];
        $totalRepayable = $principal + $totalInterest;

        $adminRatio = $product->interest_rate_flat > 0
            ? (float) $product->interest_admin_pct / $product->interest_rate_flat
            : 0.2;

        $interestAdminAmount = round($totalInterest * $adminRatio, 2);
        $interestProfitAmount = round($totalInterest - $interestAdminAmount, 2);

        $loan = Loan::create([
            'member_id' => $member->id,
            'loan_product_id' => $product->id,
            'loan_no' => Loan::generateLoanNo(),
            'principal_amount' => $principal,
            'interest_admin_pct' => $product->interest_admin_pct,
            'interest_profit_pct' => $product->interest_profit_pct,
            'total_interest' => $totalInterest,
            'interest_admin_amount' => $interestAdminAmount,
            'interest_profit_amount' => $interestProfitAmount,
            'total_repayable' => $totalRepayable,
            'tenure_months' => $tenureMonths,
            'monthly_installment' => round($totalRepayable / $tenureMonths, 2),
            'multiplier_applied' => null,
            'outstanding_balance' => max(0, round($totalRepayable - $amountRepaid, 2)),
            'status' => $amountRepaid >= $totalRepayable ? 'closed' : 'active',
            'applied_at' => $row['disbursed_date'],
            'disbursed_by' => $importedBy,
            'disbursed_at' => $row['disbursed_date'],
            'disbursement_method' => 'legacy',
            'is_legacy_import' => true,
            'closed_at' => $amountRepaid >= $totalRepayable ? now() : null,
        ]);

        $loan->generateSchedule(\Illuminate\Support\Carbon::parse($row['disbursed_date']));
        $loan->backfillRepaidSchedule($amountRepaid);

        return $loan;
    }
}
