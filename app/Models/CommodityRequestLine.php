<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommodityRequestLine extends Model
{
    protected $fillable = [
        'commodity_request_id',
        'commodity_item_id',
        'custom_item_text',
        'quantity',
        'unit_basis',
        'fixed_unit_price',
        'line_total',
        'quantity_released',
        'released_line_total',
        'shortfall_reason',
    ];

    public const SHORTFALL_NOT_IN_STOCK = 'not_in_stock';

    public const SHORTFALL_DAMAGED = 'damaged';

    public const SHORTFALL_REASONS = [
        self::SHORTFALL_NOT_IN_STOCK => 'Not in stock',
        self::SHORTFALL_DAMAGED => 'Damaged / poor condition',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'fixed_unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
        'quantity_released' => 'decimal:2',
        'released_line_total' => 'decimal:2',
    ];

    public function isReleased(): bool
    {
        return $this->quantity_released !== null;
    }

    public function wasShortSupplied(): bool
    {
        return $this->isReleased() && (float) $this->quantity_released < (float) $this->quantity;
    }

    public function shortfallLabel(): ?string
    {
        return self::SHORTFALL_REASONS[$this->shortfall_reason] ?? null;
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(CommodityRequest::class, 'commodity_request_id');
    }

    public function commodityItem(): BelongsTo
    {
        return $this->belongsTo(CommodityItem::class);
    }

    public function label(): string
    {
        return $this->commodityItem?->label() ?? ($this->custom_item_text.' (custom)');
    }
}
