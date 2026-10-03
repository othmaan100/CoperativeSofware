<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WelfareLevyPayment extends Model
{
    protected $fillable = [
        'welfare_levy_batch_id',
        'member_id',
        'period',
        'amount',
        'posted_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'posted_at' => 'datetime',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(WelfareLevyBatch::class, 'welfare_levy_batch_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
