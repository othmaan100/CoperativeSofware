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
        'set_by',
        'set_at',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'set_at' => 'datetime',
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
}
