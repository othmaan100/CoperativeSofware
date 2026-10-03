<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommodityCycle extends Model
{
    public const STATUS_OPEN = 'open';

    public const STATUS_REQUESTS_CLOSED = 'requests_closed';

    public const STATUS_PRICED = 'priced';

    public const STATUS_AUDITOR_VERIFIED = 'auditor_verified';

    public const STATUS_STORE_APPROVED = 'store_approved';

    public const STATUS_CHAIRMAN_AUTHORIZED = 'chairman_authorized';

    public const STATUS_ACTIVE = 'active';

    protected $fillable = [
        'name',
        'request_deadline',
        'status',
        'tenure_months',
        'moratorium_months',
        'markup_admin_pct',
        'markup_profit_pct',
        'opened_by',
        'priced_by',
        'priced_at',
        'auditor_verified_by',
        'auditor_verified_at',
        'store_approved_by',
        'store_approved_at',
        'chairman_authorized_by',
        'chairman_authorized_at',
    ];

    protected $casts = [
        'request_deadline' => 'date',
        'markup_admin_pct' => 'decimal:2',
        'markup_profit_pct' => 'decimal:2',
        'priced_at' => 'datetime',
        'auditor_verified_at' => 'datetime',
        'store_approved_at' => 'datetime',
        'chairman_authorized_at' => 'datetime',
    ];

    public function requests(): HasMany
    {
        return $this->hasMany(CommodityRequest::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(CommodityCyclePrice::class);
    }

    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function isRequestWindowOpen(): bool
    {
        return $this->status === self::STATUS_OPEN && now()->toDateString() <= $this->request_deadline->toDateString();
    }

    public function markupPctTotal(): float
    {
        return (float) $this->markup_admin_pct + (float) $this->markup_profit_pct;
    }

    /**
     * Aggregated demand across every (non-cancelled) request line in this
     * cycle — the sheet the committee takes to market, and what the
     * Secretary prices against.
     */
    public function demandSummary(): \Illuminate\Support\Collection
    {
        return CommodityRequestLine::query()
            ->whereHas('request', fn ($q) => $q->where('commodity_cycle_id', $this->id)->where('status', '!=', 'cancelled'))
            ->with('commodityItem')
            ->get()
            ->groupBy(fn (CommodityRequestLine $line) => $line->commodity_item_id ? 'item-'.$line->commodity_item_id : 'custom-'.strtolower($line->custom_item_text))
            ->map(function ($lines) {
                $first = $lines->first();

                return (object) [
                    'commodity_item_id' => $first->commodity_item_id,
                    'commodity_item' => $first->commodityItem,
                    'custom_item_text' => $first->custom_item_text,
                    'label' => $first->commodityItem?->label() ?? $first->custom_item_text.' (custom)',
                    'total_quantity' => $lines->sum('quantity'),
                    'unit_basis' => $first->unit_basis,
                    'request_count' => $lines->pluck('commodity_request_id')->unique()->count(),
                ];
            })
            ->values();
    }
}
