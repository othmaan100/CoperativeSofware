<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * A single pooled welfare/death-benefit fund — not one account per member
 * like savings/shares, since members don't own a withdrawable share of it.
 * Levy collections credit it, death benefit payouts debit it, and every
 * movement is an immutable WelfareFundTransaction row, mirroring the same
 * ledger pattern SavingsAccount/ShareAccount already use.
 */
class WelfareFund extends Model
{
    public const TYPE_LEVY = 'levy';

    public const TYPE_PAYOUT = 'payout';

    public const CREDIT_TYPES = [self::TYPE_LEVY];

    protected $fillable = ['balance'];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public static function singleton(): self
    {
        return self::query()->firstOrCreate(['id' => 1], ['balance' => 0]);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WelfareFundTransaction::class);
    }

    public function recordTransaction(
        string $type,
        float $amount,
        ?string $description,
        ?int $postedBy,
        ?int $sourceBatchId = null,
        ?int $claimId = null,
    ): WelfareFundTransaction {
        return DB::transaction(function () use ($type, $amount, $description, $postedBy, $sourceBatchId, $claimId) {
            /** @var self $fund */
            $fund = self::query()->lockForUpdate()->findOrFail($this->id);

            $newBalance = in_array($type, self::CREDIT_TYPES, true)
                ? bcadd((string) $fund->balance, (string) $amount, 2)
                : bcsub((string) $fund->balance, (string) $amount, 2);

            $transaction = $fund->transactions()->create([
                'type' => $type,
                'amount' => $amount,
                'balance_after' => $newBalance,
                'description' => $description,
                'posted_by' => $postedBy,
                'posted_at' => now(),
                'source_batch_id' => $sourceBatchId,
                'claim_id' => $claimId,
            ]);

            $fund->update(['balance' => $newBalance]);
            $this->setAttribute('balance', $newBalance);

            return $transaction;
        });
    }
}
