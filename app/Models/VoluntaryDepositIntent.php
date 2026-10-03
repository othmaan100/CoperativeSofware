<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoluntaryDepositIntent extends Model
{
    protected $fillable = [
        'member_id',
        'savings_account_id',
        'amount',
        'note',
        'receipt_path',
        'receipt_original_filename',
        'status',
        'confirmed_by',
        'confirmed_at',
        'decline_reason',
        'transaction_id',
        'requested_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'requested_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(SavingsAccount::class, 'savings_account_id');
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(SavingsTransaction::class, 'transaction_id');
    }
}
