<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A profit figure from the legacy (manual / pre-system) records, entered by
 * the Treasurer for a dividend period.
 */
class DividendLegacyProfit extends Model
{
    public const CATEGORIES = [
        'loan_interest' => 'Loan interest profit',
        'registration_fees' => 'Registration fee profit',
        'commodity_markup' => 'Commodity markup profit',
        'other_income' => 'Other income',
    ];

    protected $fillable = [
        'dividend_period_id',
        'category',
        'amount',
        'description',
        'entered_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(DividendPeriod::class, 'dividend_period_id');
    }

    public function enteredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'entered_by');
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? ucwords(str_replace('_', ' ', $this->category));
    }
}
