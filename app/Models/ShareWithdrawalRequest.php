<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShareWithdrawalRequest extends Model
{
    protected $fillable = [
        'member_id',
        'share_account_id',
        'shares_requested',
        'shares_approved',
        'bank_name',
        'account_number',
        'account_name',
        'reason',
        'status',
        'treasurer_reviewed_by',
        'treasurer_reviewed_at',
        'treasurer_note',
        'chairman_reviewed_by',
        'chairman_reviewed_at',
        'chairman_note',
        'disbursed_by',
        'disbursed_at',
        'requested_at',
    ];

    protected $casts = [
        'treasurer_reviewed_at' => 'datetime',
        'chairman_reviewed_at' => 'datetime',
        'disbursed_at' => 'datetime',
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
}
