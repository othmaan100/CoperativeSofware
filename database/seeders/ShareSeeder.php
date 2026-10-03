<?php

namespace Database\Seeders;

use App\Models\SharePriceHistory;
use Illuminate\Database\Seeder;

class ShareSeeder extends Seeder
{
    public function run(): void
    {
        // Starting price — Chairman/Treasurer set the real figure via the
        // Share Capital settings screen; this is a placeholder, not policy.
        if (! SharePriceHistory::query()->where('is_active', true)->exists()) {
            SharePriceHistory::create([
                'unit_price' => 1000,
                'effective_from' => now()->toDateString(),
                'set_by' => null,
                'is_active' => true,
            ]);
        }
    }
}
