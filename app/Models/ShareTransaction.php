<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShareTransaction extends Model
{
    protected $fillable = [
        'share_account_id',
        'type',
        'shares_delta',
        'unit_price_applied',
        'amount',
        'shares_after',
        'balance_after',
        'reference',
        'description',
        'source_batch_id',
        'withdrawal_request_id',
        'reversed_transaction_id',
        'posted_by',
        'posted_at',
    ];

    protected $casts = [
        'unit_price_applied' => 'decimal:2',
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'posted_at' => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(ShareAccount::class, 'share_account_id');
    }

    public function sourceBatch(): BelongsTo
    {
        return $this->belongsTo(ContributionBatch::class, 'source_batch_id');
    }

    public function withdrawalRequest(): BelongsTo
    {
        return $this->belongsTo(ShareWithdrawalRequest::class, 'withdrawal_request_id');
    }

    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function reversedTransaction(): BelongsTo
    {
        return $this->belongsTo(self::class, 'reversed_transaction_id');
    }

    public function isReversed(): bool
    {
        return self::query()->where('reversed_transaction_id', $this->id)->exists();
    }
}
