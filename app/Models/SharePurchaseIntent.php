<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SharePurchaseIntent extends Model
{
    protected $fillable = [
        'member_id',
        'share_account_id',
        'shares_requested',
        'note',
        'status',
        'confirmed_by',
        'confirmed_at',
        'decline_reason',
        'transaction_id',
        'requested_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'requested_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(ShareAccount::class, 'share_account_id');
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(ShareTransaction::class, 'transaction_id');
    }
}
