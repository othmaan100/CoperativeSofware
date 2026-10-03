<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContributionChangeRequest extends Model
{
    protected $fillable = [
        'member_id',
        'current_amount',
        'requested_amount',
        'approved_amount',
        'reason',
        'status',
        'reviewed_by',
        'reviewed_at',
        'review_note',
        'requested_at',
    ];

    protected $casts = [
        'current_amount' => 'decimal:2',
        'requested_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
        'reviewed_at' => 'datetime',
        'requested_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
