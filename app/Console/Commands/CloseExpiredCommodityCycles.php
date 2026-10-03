<?php

namespace App\Console\Commands;

use App\Models\CommodityCycle;
use Illuminate\Console\Command;

class CloseExpiredCommodityCycles extends Command
{
    protected $signature = 'commodities:close-expired-cycles';

    protected $description = 'Automatically close the request window for commodity cycles whose deadline has passed.';

    public function handle(): int
    {
        $count = CommodityCycle::query()
            ->where('status', CommodityCycle::STATUS_OPEN)
            ->where('request_deadline', '<', now()->toDateString())
            ->update(['status' => CommodityCycle::STATUS_REQUESTS_CLOSED]);

        $this->info("Closed the request window on {$count} commodity cycle(s) past their deadline.");

        return self::SUCCESS;
    }
}
