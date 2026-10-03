<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoanProduct extends Model
{
    public const REGULAR = 'regular';

    public const EMERGENCY = 'emergency';

    public const COMMODITY = 'commodity';

    protected $fillable = [
        'code',
        'name',
        'interest_admin_pct',
        'interest_profit_pct',
        'max_tenure_months',
        'min_membership_months',
        'min_savings_balance',
        'requires_guarantor',
        'min_guarantors',
        'max_guarantors',
        'disbursement_type',
        'default_after_days_overdue',
        'guarantor_grace_days',
        'is_active',
    ];

    protected $casts = [
        'interest_admin_pct' => 'decimal:2',
        'interest_profit_pct' => 'decimal:2',
        'min_savings_balance' => 'decimal:2',
        'requires_guarantor' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function limitMultipliers(): HasMany
    {
        return $this->hasMany(LoanLimitMultiplier::class);
    }

    public function getInterestRateFlatAttribute(): float
    {
        return (float) $this->interest_admin_pct + (float) $this->interest_profit_pct;
    }

    /**
     * The multiplier currently in force for this product. Historical loans
     * keep whatever multiplier was active at their own approval time —
     * this only reflects "right now", used when evaluating a new application.
     */
    public function currentMultiplier(): ?LoanLimitMultiplier
    {
        return $this->limitMultipliers()
            ->where('is_active', true)
            ->where('effective_from', '<=', now())
            ->orderByDesc('effective_from')
            ->first();
    }
}
