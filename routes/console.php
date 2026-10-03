<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('members:flag-dormant')->dailyAt('01:00');
Schedule::command('loans:process-overdue')->dailyAt('01:30');
Schedule::command('commodities:close-expired-cycles')->dailyAt('01:45');
