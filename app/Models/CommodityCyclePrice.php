<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommodityCyclePrice extends Model
{
    protected $fillable = [
        'commodity_cycle_id',
        'commodity_item_id',
        'custom_item_text',
        'unit_price',
        'original_unit_price',
        'set_by',
        'set_at',
        'revised_by',
        'revised_at',
        'quantity_in_store',
        'quantity_damaged',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'original_unit_price' => 'decimal:2',
        'set_at' => 'datetime',
        'revised_at' => 'datetime',
        'quantity_in_store' => 'decimal:2',
        'quantity_damaged' => 'decimal:2',
    ];

    public function cycle(): BelongsTo
    {
        return $this->belongsTo(CommodityCycle::class, 'commodity_cycle_id');
    }

    public function commodityItem(): BelongsTo
    {
        return $this->belongsTo(CommodityItem::class);
    }

    public function setBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'set_by');
    }

    public function revisedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revised_by');
    }

    public function label(): string
    {
        return $this->commodityItem?->label() ?? $this->custom_item_text.' (custom)';
    }

    public function wasRevisedByAuditor(): bool
    {
        return $this->original_unit_price !== null;
    }

    /** Request lines in this cycle for this item. */
    public function lines()
    {
        return CommodityRequestLine::query()
            ->where('commodity_item_id', $this->commodity_item_id)
            ->whereHas('request', fn ($q) => $q->where('commodity_cycle_id', $this->commodity_cycle_id));
    }

    public function quantityRequested(): float
    {
        return (float) $this->lines()
            ->whereHas('request', fn ($q) => $q->where('status', '!=', CommodityRequest::STATUS_CANCELLED))
            ->sum('quantity');
    }

    public function quantityReleased(?int $exceptLineId = null): float
    {
        return (float) $this->lines()
            ->when($exceptLineId, fn ($q) => $q->where('id', '!=', $exceptLineId))
            ->sum('quantity_released');
    }

    /**
     * Good-condition stock still available to release, or null when the
     * Store Officer never counted this item (cycles approved before stock
     * verification existed) — in which case release is not capped.
     */
    public function quantityAvailable(?int $exceptLineId = null): ?float
    {
        if ($this->quantity_in_store === null) {
            return null;
        }

        return max(0, round((float) $this->quantity_in_store - $this->quantityReleased($exceptLineId), 2));
    }
}
