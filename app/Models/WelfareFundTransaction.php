<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WelfareFundTransaction extends Model
{
    protected $fillable = [
        'welfare_fund_id',
        'type',
        'amount',
        'balance_after',
        'description',
        'posted_by',
        'posted_at',
        'source_batch_id',
        'claim_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'posted_at' => 'datetime',
    ];

    public function fund(): BelongsTo
    {
        return $this->belongsTo(WelfareFund::class, 'welfare_fund_id');
    }

    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function sourceBatch(): BelongsTo
    {
        return $this->belongsTo(WelfareLevyBatch::class, 'source_batch_id');
    }

    public function claim(): BelongsTo
    {
        return $this->belongsTo(WelfareClaim::class, 'claim_id');
    }
}
