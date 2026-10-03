<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanLimitMultiplier extends Model
{
    protected $fillable = [
        'loan_product_id',
        'multiplier',
        'effective_from',
        'set_by',
        'is_active',
    ];

    protected $casts = [
        'multiplier' => 'decimal:2',
        'effective_from' => 'date',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(LoanProduct::class, 'loan_product_id');
    }

    public function setBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'set_by');
    }
}
