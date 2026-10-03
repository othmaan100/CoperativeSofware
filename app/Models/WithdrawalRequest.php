<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WithdrawalRequest extends Model
{
    public const TYPE_PARTIAL = 'partial';

    public const TYPE_COMPLETE = 'complete';

    public const BENEFICIARY_MEMBER = 'member';

    public const BENEFICIARY_NEXT_OF_KIN = 'next_of_kin';

    protected $fillable = [
        'member_id',
        'savings_account_id',
        'type',
        'beneficiary_type',
        'initiated_by',
        'requested_amount',
        'approved_amount',
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
        'requested_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
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
        return $this->belongsTo(SavingsAccount::class, 'savings_account_id');
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

    public function initiatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function isComplete(): bool
    {
        return $this->type === self::TYPE_COMPLETE;
    }

    public function isForNextOfKin(): bool
    {
        return $this->beneficiary_type === self::BENEFICIARY_NEXT_OF_KIN;
    }
}
