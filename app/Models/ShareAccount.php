<?php

namespace App\Models;

use App\Support\TimeWeightedBalance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class ShareAccount extends Model
{
    public const TYPE_PURCHASE = 'purchase';

    public const TYPE_WITHDRAWAL = 'withdrawal';

    public const TYPE_REVERSAL_CREDIT = 'reversal_credit';

    public const TYPE_REVERSAL_DEBIT = 'reversal_debit';

    public const CREDIT_TYPES = [self::TYPE_PURCHASE, self::TYPE_REVERSAL_CREDIT];

    public const DEBIT_TYPES = [self::TYPE_WITHDRAWAL, self::TYPE_REVERSAL_DEBIT];

    protected $fillable = [
        'member_id',
        'account_no',
        'total_shares',
        'balance',
        'status',
        'opened_at',
        'closed_at',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(ShareTransaction::class)->orderByDesc('posted_at')->orderByDesc('id');
    }

    public function purchaseIntents(): HasMany
    {
        return $this->hasMany(SharePurchaseIntent::class);
    }

    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(ShareWithdrawalRequest::class);
    }

    public static function openFor(Member $member): self
    {
        return self::firstOrCreate(
            ['member_id' => $member->id],
            [
                'account_no' => $member->membership_no.'-SHARES',
                'total_shares' => 0,
                'balance' => 0,
                'status' => 'active',
                'opened_at' => now(),
            ]
        );
    }

    /**
     * Shares already committed to an authorized-but-undisbursed withdrawal —
     * mirrors SavingsAccount::committedWithdrawalsTotal() so two in-flight
     * requests can't independently clear the same minimum-holding floor.
     */
    public function committedWithdrawalShares(?int $excludingRequestId = null): int
    {
        return (int) $this->withdrawalRequests()
            ->whereIn('status', ['treasurer_approved', 'chairman_authorized'])
            ->when($excludingRequestId, fn ($query) => $query->where('id', '!=', $excludingRequestId))
            ->get()
            ->sum(fn ($request) => (int) ($request->shares_approved ?? $request->shares_requested));
    }

    public function availableShares(?int $excludingRequestId = null): int
    {
        return $this->total_shares - $this->committedWithdrawalShares($excludingRequestId);
    }

    /**
     * The most shares payable in a single "complete" or capped withdrawal —
     * available shares minus whatever minimum-holding floor is configured,
     * never negative.
     */
    public function maxWithdrawableShares(?int $excludingRequestId = null): int
    {
        $minimum = (int) Setting::get('minimum_share_holding', 0);

        return max(0, $this->availableShares($excludingRequestId) - $minimum);
    }

    /**
     * The ledger balance (₦ at cost) at a specific instant — see
     * SavingsAccount::balanceAsOf() for the identical rationale.
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
     * Time-weighted average balance (₦ at cost) over [$start, $end], used
     * for the Share Capital dividend calculation. See
     * App\Support\TimeWeightedBalance.
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

    /**
     * Post a transaction against this account and update the cached
     * total_shares/balance atomically. This is the ONLY way a share
     * account's holdings should ever change.
     */
    public function recordTransaction(
        string $type,
        int $shares,
        float $unitPrice,
        string $description,
        ?int $postedBy,
        ?string $reference = null,
        ?int $sourceBatchId = null,
        ?int $withdrawalRequestId = null,
        ?int $reversedTransactionId = null,
    ): ShareTransaction {
        return DB::transaction(function () use ($type, $shares, $unitPrice, $description, $postedBy, $reference, $sourceBatchId, $withdrawalRequestId, $reversedTransactionId) {
            /** @var self $account */
            $account = self::query()->lockForUpdate()->findOrFail($this->id);

            $amount = round($shares * $unitPrice, 2);
            $isCredit = in_array($type, self::CREDIT_TYPES, true);

            $newShares = $isCredit ? $account->total_shares + $shares : $account->total_shares - $shares;
            $newBalance = $isCredit
                ? bcadd((string) $account->balance, (string) $amount, 2)
                : bcsub((string) $account->balance, (string) $amount, 2);

            $transaction = $account->transactions()->create([
                'type' => $type,
                'shares_delta' => $isCredit ? $shares : -$shares,
                'unit_price_applied' => $unitPrice,
                'amount' => $amount,
                'shares_after' => $newShares,
                'balance_after' => $newBalance,
                'reference' => $reference,
                'description' => $description,
                'posted_by' => $postedBy,
                'posted_at' => now(),
                'source_batch_id' => $sourceBatchId,
                'withdrawal_request_id' => $withdrawalRequestId,
                'reversed_transaction_id' => $reversedTransactionId,
            ]);

            $account->update(['total_shares' => $newShares, 'balance' => $newBalance]);
            $this->setAttribute('total_shares', $newShares);
            $this->setAttribute('balance', $newBalance);

            return $transaction;
        });
    }
}
