<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommodityItem extends Model
{
    protected $fillable = [
        'description',
        'type_brand',
        'pack_unit',
        'unit_options',
        'is_active',
        'created_from_request_line_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'unit_options' => 'array',
    ];

    public function createdFromRequestLine(): BelongsTo
    {
        return $this->belongsTo(CommodityRequestLine::class, 'created_from_request_line_id');
    }

    public function label(): string
    {
        return trim($this->description.($this->type_brand ? " ({$this->type_brand})" : '').' — '.$this->pack_unit);
    }

    public function hasUnitOptions(): bool
    {
        return ! empty($this->unit_options);
    }

    /**
     * Parses a comma-separated string (as entered on the catalogue form)
     * into a clean array of option labels — trims whitespace and drops
     * empty entries, so "Full bag,  , Half bag" and "Full bag, Half bag"
     * store identically.
     */
    public static function parseUnitOptions(string $commaSeparated): ?array
    {
        $options = collect(explode(',', $commaSeparated))
            ->map(fn ($option) => trim($option))
            ->filter(fn ($option) => $option !== '')
            ->values()
            ->all();

        return empty($options) ? null : $options;
    }

    public function unitOptionsAsString(): string
    {
        return implode(', ', $this->unit_options ?? []);
    }
}
