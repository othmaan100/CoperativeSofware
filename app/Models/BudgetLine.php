<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetLine extends Model
{
    protected $fillable = [
        'budget_id',
        'category',
        'budgeted_amount',
        'notes',
    ];

    protected $casts = [
        'budgeted_amount' => 'decimal:2',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function categoryLabel(): string
    {
        return Budget::categoryLabel($this->category);
    }

    public function paidAmount(): float
    {
        return round((float) $this->expenses()->where('status', Expense::STATUS_PAID)->sum('amount'), 2);
    }

    public function committedAmount(): float
    {
        return round((float) $this->expenses()->whereIn('status', [Expense::STATUS_PENDING, Expense::STATUS_CHAIRMAN_AUTHORIZED])->sum('amount'), 2);
    }

    public function variance(): float
    {
        return round((float) $this->budgeted_amount - $this->paidAmount(), 2);
    }
}
