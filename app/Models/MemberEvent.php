<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberEvent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'member_id',
        'event_type',
        'payload',
        'caused_by',
    ];

    protected $casts = [
        'payload' => 'array',
        'created_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function causedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'caused_by');
    }
}
