<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Loan extends Model
{
    public const ACTIVE_STATUSES = ['disbursed', 'active', 'overdue', 'defaulted'];

    protected $fillable = [
        'member_id',
        'loan_product_id',
        'loan_no',
        'principal_amount',
        'interest_admin_pct',
        'interest_profit_pct',
        'total_interest',
        'interest_admin_amount',
        'interest_profit_amount',
        'total_repayable',
        'tenure_months',
        'monthly_installment',
        'multiplier_applied',
        'outstanding_balance',
        'status',
        'applied_at',
        'treasurer_reviewed_by',
        'treasurer_reviewed_at',
        'treasurer_note',
        'chairman_reviewed_by',
        'chairman_reviewed_at',
        'chairman_note',
        'disbursed_by',
        'disbursed_at',
        'disbursement_method',
        'disbursement_reference',
        'is_legacy_import',
        'defaulted_at',
        'closed_at',
    ];

    protected $casts = [
        'principal_amount' => 'decimal:2',
        'interest_admin_pct' => 'decimal:2',
        'interest_profit_pct' => 'decimal:2',
        'total_interest' => 'decimal:2',
        'interest_admin_amount' => 'decimal:2',
        'interest_profit_amount' => 'decimal:2',
        'total_repayable' => 'decimal:2',
        'monthly_installment' => 'decimal:2',
        'multiplier_applied' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'applied_at' => 'datetime',
        'treasurer_reviewed_at' => 'datetime',
        'chairman_reviewed_at' => 'datetime',
        'disbursed_at' => 'datetime',
        'is_legacy_import' => 'boolean',
        'defaulted_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(LoanProduct::class, 'loan_product_id');
    }

    public function guarantors(): HasMany
    {
        return $this->hasMany(LoanGuarantor::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable')->latest();
    }

    /**
     * Outstanding balance at a specific instant, for point-in-time financial
     * statements (Balance Sheet). Disbursement itself has no ledger row (it
     * sets outstanding_balance = total_repayable directly), so a loan with
     * no repayment transactions yet as of $date is still owed in full —
     * only an actual repayment row moves the needle.
     */
    public function outstandingBalanceAsOf(Carbon $date): float
    {
        if (! $this->disbursed_at || $this->disbursed_at->greaterThan($date)) {
            return 0.0;
        }

        $lastRepayment = $this->repaymentTransactions()
            ->reorder()
            ->where('posted_at', '<=', $date)
            ->orderByDesc('posted_at')
            ->orderByDesc('id')
            ->value('balance_after');

        return $lastRepayment !== null ? (float) $lastRepayment : (float) $this->total_repayable;
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(LoanRepaymentSchedule::class)->orderBy('installment_no');
    }

    public function repaymentTransactions(): HasMany
    {
        return $this->hasMany(LoanRepaymentTransaction::class)->orderByDesc('posted_at')->orderByDesc('id');
    }

    public function repaymentIntents(): HasMany
    {
        return $this->hasMany(LoanRepaymentIntent::class);
    }

    public function savingsRepaymentRequests(): HasMany
    {
        return $this->hasMany(LoanSavingsRepaymentRequest::class);
    }

    public function treasurerReviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'treasurer_reviewed_by');
    }

    public function chairmanReviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chairman_reviewed_by');
    }

    public function disbursedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disbursed_by');
    }

    public function commodityRequest(): HasOne
    {
        return $this->hasOne(CommodityRequest::class);
    }

    public function isActiveExposure(): bool
    {
        return in_array($this->status, self::ACTIVE_STATUSES, true);
    }

    public function totalPaid(): float
    {
        return max(0, (float) $this->total_repayable - (float) $this->outstanding_balance);
    }

    /**
     * Sequential loan number, e.g. LN/00001.
     */
    public static function generateLoanNo(): string
    {
        return DB::transaction(function () {
            $last = static::query()->lockForUpdate()->orderByDesc('id')->value('loan_no');

            $next = 1;
            if ($last && preg_match('/(\d+)$/', $last, $matches)) {
                $next = ((int) $matches[1]) + 1;
            }

            return sprintf('LN/%05d', $next);
        });
    }

    /**
     * Flat-rate interest breakdown for a given principal/product/tenure,
     * computed on the principal per the society's 2% admin + 8% profit rule.
     */
    public static function computeAmounts(float $principal, LoanProduct $product, int $tenureMonths): array
    {
        $adminAmount = round($principal * (float) $product->interest_admin_pct / 100, 2);
        $profitAmount = round($principal * (float) $product->interest_profit_pct / 100, 2);
        $totalInterest = round($adminAmount + $profitAmount, 2);
        $totalRepayable = round($principal + $totalInterest, 2);
        $monthlyInstallment = $tenureMonths > 0 ? round($totalRepayable / $tenureMonths, 2) : $totalRepayable;

        return [
            'interest_admin_amount' => $adminAmount,
            'interest_profit_amount' => $profitAmount,
            'total_interest' => $totalInterest,
            'total_repayable' => $totalRepayable,
            'monthly_installment' => $monthlyInstallment,
        ];
    }

    /**
     * Savings-linked eligibility check for a new application: current
     * savings balance x the product's active multiplier, independent of
     * any other active loan the member already holds (per society policy —
     * each application is evaluated on its own).
     */
    public static function evaluateEligibility(Member $member, LoanProduct $product, float $requestedAmount): array
    {
        $violations = [];

        $membershipMonths = $member->applied_at ? $member->applied_at->diffInMonths(now()) : 0;
        if ($product->min_membership_months > 0 && $membershipMonths < $product->min_membership_months) {
            $violations[] = "Minimum membership duration of {$product->min_membership_months} month(s) has not yet been met.";
        }

        $savingsBalance = (float) $member->savingsAccounts()->sum('balance');
        if ((float) $product->min_savings_balance > 0 && $savingsBalance < (float) $product->min_savings_balance) {
            $violations[] = 'Minimum savings balance required for this loan product has not been met.';
        }

        $multiplierRecord = $product->currentMultiplier();
        $multiplier = $multiplierRecord ? (float) $multiplierRecord->multiplier : 0.0;
        $maxAmount = round($savingsBalance * $multiplier, 2);

        if ($multiplier <= 0) {
            $violations[] = 'No active loan limit multiplier is configured for this product yet.';
        } elseif ($requestedAmount > $maxAmount) {
            $violations[] = 'Requested amount exceeds the maximum allowed of ₦'.number_format($maxAmount, 2)." ({$multiplier}x current savings balance).";
        }

        return [
            'max_amount' => $maxAmount,
            'multiplier' => $multiplier,
            'savings_balance' => $savingsBalance,
            'violations' => $violations,
        ];
    }

    /**
     * Build the repayment schedule from an anchor date (disbursement), with
     * the first installment due one month later. The final installment
     * absorbs any rounding remainder so the schedule sums exactly to the
     * total repayable amount.
     */
    public function generateSchedule(Carbon $anchorDate): void
    {
        $running = 0.0;

        for ($i = 1; $i <= $this->tenure_months; $i++) {
            $isLast = $i === $this->tenure_months;
            $amountDue = $isLast
                ? round((float) $this->total_repayable - $running, 2)
                : round((float) $this->monthly_installment, 2);

            $running += $amountDue;

            $this->schedules()->create([
                'installment_no' => $i,
                'due_date' => $anchorDate->copy()->addMonthsNoOverflow($i)->toDateString(),
                'amount_due' => $amountDue,
                'amount_paid' => 0,
                'status' => 'pending',
            ]);
        }
    }

    /**
     * Retroactively mark schedule installments as paid up to the supplied
     * cumulative amount (oldest first), and record a single summarizing
     * transaction — used only by the legacy loan import.
     */
    public function backfillRepaidSchedule(float $amountRepaid, ?int $postedBy = null): void
    {
        if ($amountRepaid <= 0) {
            return;
        }

        $remaining = $amountRepaid;

        foreach ($this->schedules()->orderBy('installment_no')->get() as $schedule) {
            if ($remaining <= 0) {
                break;
            }

            $apply = min($remaining, (float) $schedule->amount_due);
            $schedule->update([
                'amount_paid' => $apply,
                'status' => $apply >= (float) $schedule->amount_due ? 'paid' : 'partially_paid',
            ]);
            $remaining -= $apply;
        }

        $this->repaymentTransactions()->create([
            'type' => 'salary_deduction',
            'amount' => $amountRepaid,
            'balance_after' => (float) $this->outstanding_balance,
            'description' => 'Legacy repayment history (imported)',
            'posted_by' => $postedBy,
            'posted_at' => $this->disbursed_at ?? now(),
        ]);
    }

    /**
     * Post a repayment against this loan and update the cached outstanding
     * balance atomically — the ONLY way a loan's balance should change.
     * Applies FIFO against the oldest unpaid/overdue installment(s) first.
     */
    public function recordRepayment(
        string $type,
        float $amount,
        ?int $postedBy,
        ?string $reference = null,
        ?int $sourceBatchId = null,
        ?string $description = null,
    ): LoanRepaymentTransaction {
        return DB::transaction(function () use ($type, $amount, $postedBy, $reference, $sourceBatchId, $description) {
            /** @var self $loan */
            $loan = self::query()->lockForUpdate()->findOrFail($this->id);

            $newOutstanding = max(0, (float) bcsub((string) $loan->outstanding_balance, (string) $amount, 2));

            $remaining = $amount;
            $touchedScheduleId = null;

            foreach ($loan->schedules()->whereIn('status', ['pending', 'partially_paid', 'overdue'])->orderBy('installment_no')->get() as $schedule) {
                if ($remaining <= 0) {
                    break;
                }

                $due = $schedule->balanceRemaining();
                if ($due <= 0) {
                    continue;
                }

                $apply = min($remaining, $due);
                $newPaid = (float) bcadd((string) $schedule->amount_paid, (string) $apply, 2);

                $schedule->update([
                    'amount_paid' => $newPaid,
                    'status' => $newPaid >= (float) $schedule->amount_due ? 'paid' : 'partially_paid',
                ]);

                $touchedScheduleId ??= $schedule->id;
                $remaining -= $apply;
            }

            $transaction = $loan->repaymentTransactions()->create([
                'schedule_id' => $touchedScheduleId,
                'type' => $type,
                'amount' => $amount,
                'balance_after' => $newOutstanding,
                'reference' => $reference,
                'description' => $description,
                'source_batch_id' => $sourceBatchId,
                'posted_by' => $postedBy,
                'posted_at' => now(),
            ]);

            $loan->outstanding_balance = $newOutstanding;
            if ($newOutstanding <= 0 && $loan->status !== 'closed') {
                $loan->status = 'closed';
                $loan->closed_at = now();
            }
            $loan->save();

            $this->setAttribute('outstanding_balance', $newOutstanding);
            $this->setAttribute('status', $loan->status);

            return $transaction;
        });
    }

    /**
     * Sweep this loan's schedule for newly-overdue installments, and escalate
     * to 'defaulted' once the oldest overdue installment has aged past the
     * product's configured default threshold. Simple flagging only — no
     * penalty interest, matching the society's stated policy.
     */
    public function refreshOverdueStatus(): void
    {
        if (! in_array($this->status, ['active', 'overdue', 'defaulted'], true)) {
            return;
        }

        $today = now()->toDateString();

        $this->schedules()
            ->where('due_date', '<', $today)
            ->whereIn('status', ['pending', 'partially_paid'])
            ->get()
            ->each(fn (LoanRepaymentSchedule $schedule) => $schedule->update(['status' => 'overdue']));

        $oldestOverdueDate = $this->schedules()->where('status', 'overdue')->min('due_date');

        if (! $oldestOverdueDate) {
            if (in_array($this->status, ['overdue', 'defaulted'], true)) {
                $this->update(['status' => 'active']);
            }

            return;
        }

        $daysOverdue = Carbon::parse($oldestOverdueDate)->diffInDays(now());

        if ($daysOverdue >= $this->product->default_after_days_overdue) {
            if ($this->status !== 'defaulted') {
                $this->update(['status' => 'defaulted', 'defaulted_at' => now()]);
            }
        } elseif ($this->status !== 'defaulted') {
            $this->update(['status' => 'overdue']);
        }
    }

    /**
     * Once a loan has been in 'defaulted' status for longer than the
     * product's guarantor grace period, call each accepted-but-not-yet-called
     * guarantor's pledge: deduct it from their own savings and apply it
     * against this loan's outstanding balance. Never a silent adjustment —
     * both sides post a normal, referenced ledger transaction.
     */
    public function callGuarantorsIfDue(): void
    {
        if ($this->status !== 'defaulted' || ! $this->defaulted_at) {
            return;
        }

        if (now()->lt($this->defaulted_at->copy()->addDays($this->product->guarantor_grace_days))) {
            return;
        }

        foreach ($this->guarantors()->where('status', 'accepted')->whereNull('called_at')->get() as $guarantor) {
            $account = $guarantor->guarantorMember->regularSavingsAccount();
            if (! $account) {
                continue;
            }

            $amount = min((float) $guarantor->pledged_amount, (float) $account->balance);
            if ($amount <= 0) {
                continue;
            }

            $deduction = $account->recordTransaction(
                type: 'loan_guarantor_deduction',
                amount: $amount,
                description: "Guarantor pledge called for defaulted loan {$this->loan_no}",
                postedBy: null,
                reference: "LOAN-{$this->id}-GUARANTOR-{$guarantor->id}",
            );

            $guarantor->update([
                'called_at' => now(),
                'deduction_transaction_id' => $deduction->id,
            ]);

            $this->recordRepayment(
                type: 'voluntary_lump_sum',
                amount: $amount,
                postedBy: null,
                reference: "GUARANTOR-{$guarantor->id}",
                description: "Guarantor pledge called ({$guarantor->guarantorMember->full_name})",
            );
        }
    }
}
