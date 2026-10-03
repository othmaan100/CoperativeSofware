<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DividendAllocation extends Model
{
    protected $fillable = [
        'dividend_period_id',
        'member_id',
        'average_share_balance',
        'average_savings_balance',
        'share_rate_applied',
        'savings_rate_applied',
        'share_dividend_amount',
        'savings_interest_amount',
        'status',
        'dividend_transaction_id',
        'interest_transaction_id',
    ];

    protected $casts = [
        'average_share_balance' => 'decimal:2',
        'average_savings_balance' => 'decimal:2',
        'share_rate_applied' => 'decimal:2',
        'savings_rate_applied' => 'decimal:2',
        'share_dividend_amount' => 'decimal:2',
        'savings_interest_amount' => 'decimal:2',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(DividendPeriod::class, 'dividend_period_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function dividendTransaction(): BelongsTo
    {
        return $this->belongsTo(SavingsTransaction::class, 'dividend_transaction_id');
    }

    public function interestTransaction(): BelongsTo
    {
        return $this->belongsTo(SavingsTransaction::class, 'interest_transaction_id');
    }
}
