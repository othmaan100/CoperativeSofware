<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReversalRequest extends Model
{
    protected $fillable = [
        'original_transaction_id',
        'reason',
        'initiated_by',
        'authorized_by',
        'status',
        'decline_reason',
        'resulting_transaction_id',
        'requested_at',
        'authorized_at',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'authorized_at' => 'datetime',
    ];

    public function originalTransaction(): BelongsTo
    {
        return $this->belongsTo(SavingsTransaction::class, 'original_transaction_id');
    }

    public function resultingTransaction(): BelongsTo
    {
        return $this->belongsTo(SavingsTransaction::class, 'resulting_transaction_id');
    }

    public function initiatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function authorizedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'authorized_by');
    }
}
