<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SavingsProduct extends Model
{
    protected $fillable = [
        'code',
        'name',
        'is_interest_bearing',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_interest_bearing' => 'boolean',
        'is_active' => 'boolean',
    ];

    public const REGULAR = 'regular';

    public const TARGET = 'target';

    public function accounts(): HasMany
    {
        return $this->hasMany(SavingsAccount::class);
    }

    public function withdrawalConditions(): HasMany
    {
        return $this->hasMany(WithdrawalCondition::class);
    }
}
