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
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'fixed_unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

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
