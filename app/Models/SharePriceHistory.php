<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SharePriceHistory extends Model
{
    protected $table = 'share_price_history';

    protected $fillable = [
        'unit_price',
        'effective_from',
        'set_by',
        'is_active',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'effective_from' => 'date',
        'is_active' => 'boolean',
    ];

    public function setBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'set_by');
    }

    public static function current(): ?self
    {
        return self::query()
            ->where('is_active', true)
            ->where('effective_from', '<=', now())
            ->orderByDesc('effective_from')
            ->first();
    }

    public static function currentPrice(): float
    {
        return (float) (self::current()?->unit_price ?? 1000);
    }
}
