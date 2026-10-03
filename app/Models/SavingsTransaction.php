<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingsTransaction extends Model
{
    protected $fillable = [
        'savings_account_id',
        'type',
        'amount',
        'balance_after',
        'reference',
        'description',
        'posted_by',
        'posted_at',
        'source_batch_id',
        'withdrawal_request_id',
        'reversed_transaction_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'posted_at' => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(SavingsAccount::class, 'savings_account_id');
    }

    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function sourceBatch(): BelongsTo
    {
        return $this->belongsTo(ContributionBatch::class, 'source_batch_id');
    }

    public function withdrawalRequest(): BelongsTo
    {
        return $this->belongsTo(WithdrawalRequest::class);
    }

    public function reversedTransaction(): BelongsTo
    {
        return $this->belongsTo(self::class, 'reversed_transaction_id');
    }

    public function isCredit(): bool
    {
        return in_array($this->type, SavingsAccount::CREDIT_TYPES, true);
    }

    public function isReversed(): bool
    {
        return $this->reversalRequestApplied()->exists();
    }

    public function reversalRequestApplied()
    {
        return ReversalRequest::query()
            ->where('original_transaction_id', $this->id)
            ->where('status', 'applied');
    }
}
