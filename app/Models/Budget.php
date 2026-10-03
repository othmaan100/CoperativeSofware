<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    public const STATUS_DRAFT = 'draft';

    public const STATUS_PENDING_APPROVAL = 'pending_approval';

    public const STATUS_APPROVED = 'approved';

    public const CATEGORIES = [
        'salaries' => 'Salaries & Honoraria',
        'rent' => 'Rent',
        'utilities' => 'Utilities',
        'agm_meetings' => 'AGM & Meetings',
        'audit_fees' => 'Audit Fees',
        'training' => 'Training & Capacity Building',
        'stationery' => 'Stationery & Office Supplies',
        'maintenance' => 'Maintenance & Repairs',
        'insurance' => 'Insurance',
        'miscellaneous' => 'Miscellaneous',
    ];

    protected $fillable = [
        'fy_start_year',
        'status',
        'proposed_by',
        'proposed_at',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'proposed_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function lines(): HasMany
    {
        return $this->hasMany(BudgetLine::class);
    }

    public function proposedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'proposed_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function totalBudgeted(): float
    {
        return round((float) $this->lines()->sum('budgeted_amount'), 2);
    }

    public static function categoryLabel(string $category): string
    {
        return self::CATEGORIES[$category] ?? ucfirst($category);
    }
}
