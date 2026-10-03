<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberChangeRequest extends Model
{
    protected $fillable = [
        'member_id',
        'field_name',
        'old_value',
        'new_value',
        'status',
        'requested_by',
        'reviewed_by',
        'reviewed_at',
        'review_reason',
        'requested_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'requested_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function fieldLabel(): string
    {
        return ucwords(str_replace('_', ' ', $this->field_name));
    }
}
