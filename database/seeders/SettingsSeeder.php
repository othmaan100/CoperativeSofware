<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::query()->updateOrCreate(
            ['key' => 'dormancy_months'],
            ['value' => 6]
        );

        Setting::query()->updateOrCreate(
            ['key' => 'minimum_monthly_contribution'],
            ['value' => 5000]
        );

        Setting::query()->updateOrCreate(
            ['key' => 'application_form_fee'],
            ['value' => 5000]
        );

        // Same admin-charge/profit split concept as loans (2%/8%), scaled to
        // this flat fee — Chairman-editable via the Registration Fee report.
        Setting::query()->updateOrCreate(
            ['key' => 'application_fee_admin_pct'],
            ['value' => 20]
        );

        Setting::query()->updateOrCreate(
            ['key' => 'application_fee_profit_pct'],
            ['value' => 80]
        );

        // Minimum whole shares a member must keep — a share withdrawal can
        // never take a holding below this floor. Chairman/Treasurer-editable.
        Setting::query()->updateOrCreate(
            ['key' => 'minimum_share_holding'],
            ['value' => 5]
        );

        // Month (1-12) the dividend financial year starts on — placeholder
        // default, Chairman sets the real value via Dividend Declarations.
        Setting::query()->updateOrCreate(
            ['key' => 'dividend_fy_start_month'],
            ['value' => 1]
        );
    }
}
