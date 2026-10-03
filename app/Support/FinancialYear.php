<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Carbon;

/**
 * The cooperative's financial year, driven by the same
 * `dividend_fy_start_month` setting the Dividends module already exposes to
 * the Chairman — one organisation-wide financial year, not a second one
 * invented for this module.
 */
class FinancialYear
{
    public static function startMonth(): int
    {
        return (int) Setting::get('dividend_fy_start_month', 1);
    }

    /**
     * The financial year, identified by the calendar year its FIRST month
     * falls in (e.g. if the FY starts in September, "FY 2025" runs
     * 1 Sep 2025 - 31 Aug 2026).
     */
    public static function boundsFor(int $startYear): array
    {
        $month = self::startMonth();
        $start = Carbon::create($startYear, $month, 1)->startOfDay();
        $end = $start->copy()->addYear()->subDay()->endOfDay();

        return [$start, $end];
    }

    public static function labelFor(int $startYear): string
    {
        [$start, $end] = self::boundsFor($startYear);

        return $start->year === $end->year
            ? 'FY '.$start->year
            : 'FY '.$start->year.'/'.$end->year;
    }

    /**
     * The financial year that "now" (or a given instant) falls inside.
     */
    public static function current(?Carbon $asOf = null): array
    {
        $asOf = $asOf ?? now();
        $month = self::startMonth();
        $startYear = $asOf->month >= $month ? $asOf->year : $asOf->year - 1;

        return [$startYear, ...self::boundsFor($startYear)];
    }

    /**
     * Every financial-year start year that has at least one relevant record,
     * newest first — for populating a year picker without hardcoding a
     * range or showing years with nothing in them.
     */
    public static function availableStartYears(): array
    {
        $earliest = self::earliestActivityDate();
        [$currentStartYear] = self::current();

        if (! $earliest) {
            return [$currentStartYear];
        }

        $month = self::startMonth();
        $earliestStartYear = $earliest->month >= $month ? $earliest->year : $earliest->year - 1;

        return range($currentStartYear, $earliestStartYear, -1);
    }

    protected static function earliestActivityDate(): ?Carbon
    {
        $dates = [
            \App\Models\Loan::query()->whereNotNull('disbursed_at')->min('disbursed_at'),
            \App\Models\ApplicationFeePayment::query()->whereNotNull('paid_at')->min('paid_at'),
            \App\Models\SavingsTransaction::query()->min('posted_at'),
            \App\Models\ShareTransaction::query()->min('posted_at'),
        ];

        $dates = array_filter($dates);

        if (empty($dates)) {
            return null;
        }

        return Carbon::parse(min($dates));
    }
}
