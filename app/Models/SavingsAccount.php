<?php

namespace App\Models;

use App\Support\TimeWeightedBalance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class SavingsAccount extends Model
{
    public const CREDIT_TYPES = ['contribution_deduction', 'voluntary_deposit', 'reversal_credit', 'opening_balance', 'dividend_credit', 'interest_credit'];

    public const DEBIT_TYPES = ['withdrawal', 'reversal_debit', 'loan_guarantor_deduction', 'loan_repayment_transfer'];

    protected $fillable = [
        'member_id',
        'savings_product_id',
        'account_no',
        'target_amount',
        'target_date',
        'balance',
        'status',
        'opened_at',
        'closed_at',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'target_date' => 'date',
        'balance' => 'decimal:2',
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(SavingsProduct::class, 'savings_product_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(SavingsTransaction::class)->orderByDesc('posted_at')->orderByDesc('id');
    }

    public function voluntaryDepositIntents(): HasMany
    {
        return $this->hasMany(VoluntaryDepositIntent::class);
    }

    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(WithdrawalRequest::class);
    }

    public function loanSavingsRepaymentRequests(): HasMany
    {
        return $this->hasMany(LoanSavingsRepaymentRequest::class);
    }

    /**
     * Sum of withdrawals that have been authorized but not yet disbursed —
     * money that is committed to leave the account even though the ledger
     * transaction (and the cached balance) won't change until disbursement.
     */
    public function committedWithdrawalsTotal(?int $excludingRequestId = null): float
    {
        return (float) $this->withdrawalRequests()
            ->whereIn('status', ['treasurer_approved', 'chairman_authorized'])
            ->when($excludingRequestId, fn ($query) => $query->where('id', '!=', $excludingRequestId))
            ->get()
            ->sum(fn ($request) => (float) ($request->approved_amount ?? $request->requested_amount));
    }

    /**
     * Sum of pending "repay my loan from savings" requests — these have a
     * single approval step that both authorizes and immediately executes the
     * transfer, so only 'pending' ones are still uncommitted money (there is
     * no approved-but-undisbursed limbo state like withdrawals have).
     */
    public function committedLoanSavingsRepaymentsTotal(?int $excludingRequestId = null): float
    {
        return (float) $this->loanSavingsRepaymentRequests()
            ->where('status', LoanSavingsRepaymentRequest::STATUS_PENDING)
            ->when($excludingRequestId, fn ($query) => $query->where('id', '!=', $excludingRequestId))
            ->sum('amount');
    }

    /**
     * Balance minus anything already committed to an authorized-but-undisbursed
     * withdrawal or a pending savings-to-loan repayment request — this is what
     * withdrawal (and repayment) rules should be evaluated against, so two
     * requests can't independently commit the same naira.
     */
    public function availableBalance(?int $excludingWithdrawalRequestId = null, ?int $excludingLoanSavingsRepaymentRequestId = null): float
    {
        return (float) $this->balance
            - $this->committedWithdrawalsTotal($excludingWithdrawalRequestId)
            - $this->committedLoanSavingsRepaymentsTotal($excludingLoanSavingsRepaymentRequestId);
    }

    /**
     * The maximum amount payable as a "complete withdrawal" — the available
     * balance minus whatever minimum-balance floor is configured for this
     * account's product (0 if no such rule exists) and minus any voluntary
     * deposits still within their hold period, never negative.
     */
    public function maxCompleteWithdrawalAmount(?int $excludingRequestId = null): float
    {
        $minimum = (float) (WithdrawalCondition::query()
            ->where('savings_product_id', $this->savings_product_id)
            ->where('rule_type', 'minimum_balance')
            ->where('is_active', true)
            ->value('value') ?? 0);

        return max(0, $this->availableBalance($excludingRequestId) - $minimum - $this->lockedVoluntaryDepositTotal());
    }

    /**
     * Sum of voluntary deposits posted within the hold period (still
     * "immature" and not yet withdrawable) — capped at the current balance
     * so it can never claim to lock more than is actually in the account.
     * Compulsory contribution_deduction credits are never included here, so
     * they remain freely withdrawable regardless of this rule.
     */
    public function lockedVoluntaryDepositTotal(): float
    {
        $months = (int) Setting::get('voluntary_deposit_lock_months', 3);
        $cutoff = now()->subMonths($months);

        $recent = (float) $this->transactions()
            ->reorder()
            ->where('type', 'voluntary_deposit')
            ->where('posted_at', '>', $cutoff)
            ->sum('amount');

        return min((float) $this->balance, $recent);
    }

    /**
     * Available balance minus any still-locked voluntary deposits — the
     * ceiling a partial withdrawal (or savings-to-loan repayment) request
     * must respect.
     */
    public function withdrawableBalance(?int $excludingWithdrawalRequestId = null, ?int $excludingLoanSavingsRepaymentRequestId = null): float
    {
        return max(0, $this->availableBalance($excludingWithdrawalRequestId, $excludingLoanSavingsRepaymentRequestId) - $this->lockedVoluntaryDepositTotal());
    }

    /**
     * When the OLDEST still-locked voluntary deposit will mature — null if
     * nothing is currently locked. For member-facing disclosure only; the
     * lock amount itself is always recomputed live from the ledger.
     */
    public function nextVoluntaryDepositMaturityDate(): ?Carbon
    {
        $months = (int) Setting::get('voluntary_deposit_lock_months', 3);
        $cutoff = now()->subMonths($months);

        $earliest = $this->transactions()
            ->reorder()
            ->where('type', 'voluntary_deposit')
            ->where('posted_at', '>', $cutoff)
            ->orderBy('posted_at')
            ->value('posted_at');

        return $earliest ? Carbon::parse($earliest)->addMonths($months) : null;
    }

    /**
     * The ledger balance at a specific instant — the balance_after of the
     * latest transaction posted at or before $date, or 0 if the account had
     * no transactions yet (including if it didn't exist yet). Used for
     * point-in-time financial statements (Balance Sheet), as opposed to
     * averageBalanceBetween()'s time-weighted average used for dividends.
     */
    public function balanceAsOf(Carbon $date): float
    {
        return (float) ($this->transactions()
            ->reorder()
            ->where('posted_at', '<=', $date)
            ->orderByDesc('posted_at')
            ->orderByDesc('id')
            ->value('balance_after') ?? 0);
    }

    /**
     * Time-weighted average balance over [$start, $end], used for dividend
     * and savings-interest calculations. See App\Support\TimeWeightedBalance.
     */
    public function averageBalanceBetween(Carbon $start, Carbon $end): float
    {
        $opening = (float) ($this->transactions()
            ->reorder()
            ->where('posted_at', '<', $start)
            ->orderByDesc('posted_at')
            ->orderByDesc('id')
            ->value('balance_after') ?? 0);

        $inPeriod = $this->transactions()
            ->reorder()
            ->whereBetween('posted_at', [$start, $end])
            ->orderBy('posted_at')
            ->orderBy('id')
            ->get();

        return TimeWeightedBalance::average($inPeriod, $opening, $start, $end);
    }

    public static function generateAccountNo(Member $member, SavingsProduct $product): string
    {
        return $member->membership_no.'-'.strtoupper($product->code);
    }

    public static function openFor(Member $member, SavingsProduct $product): self
    {
        return self::firstOrCreate(
            ['member_id' => $member->id, 'savings_product_id' => $product->id],
            [
                'account_no' => self::generateAccountNo($member, $product),
                'balance' => 0,
                'status' => 'active',
                'opened_at' => now(),
            ]
        );
    }

    /**
     * Post a transaction against this account and update the cached balance
     * atomically. This is the ONLY way balances should ever change.
     */
    public function recordTransaction(
        string $type,
        float $amount,
        string $description,
        ?int $postedBy,
        ?string $reference = null,
        ?int $sourceBatchId = null,
        ?int $withdrawalRequestId = null,
        ?int $reversedTransactionId = null,
    ): SavingsTransaction {
        return DB::transaction(function () use ($type, $amount, $description, $postedBy, $reference, $sourceBatchId, $withdrawalRequestId, $reversedTransactionId) {
            /** @var self $account */
            $account = self::query()->lockForUpdate()->findOrFail($this->id);

            $newBalance = in_array($type, self::CREDIT_TYPES, true)
                ? bcadd((string) $account->balance, (string) $amount, 2)
                : bcsub((string) $account->balance, (string) $amount, 2);

            $transaction = $account->transactions()->create([
                'type' => $type,
                'amount' => $amount,
                'balance_after' => $newBalance,
                'reference' => $reference,
                'description' => $description,
                'posted_by' => $postedBy,
                'posted_at' => now(),
                'source_batch_id' => $sourceBatchId,
                'withdrawal_request_id' => $withdrawalRequestId,
                'reversed_transaction_id' => $reversedTransactionId,
            ]);

            $account->update(['balance' => $newBalance]);
            $this->setAttribute('balance', $newBalance);

            return $transaction;
        });
    }
}
