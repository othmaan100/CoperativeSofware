<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class TimeWeightedBalance
{
    /**
     * Average balance over [$start, $end], computed from an immutable
     * transaction ledger (the standard "average daily/second balance"
     * method used for interest calculations).
     *
     * $transactionsInPeriodAsc must contain only transactions posted within
     * [$start, $end], ordered ascending by posted_at, each exposing a
     * Carbon `posted_at` and a numeric value at $balanceKey. $openingBalance
     * is the ledger balance immediately before $start (0 if the account did
     * not exist yet).
     */
    public static function average(
        Collection $transactionsInPeriodAsc,
        float $openingBalance,
        Carbon $start,
        Carbon $end,
        string $balanceKey = 'balance_after',
    ): float {
        $totalSeconds = $start->diffInSeconds($end);

        if ($totalSeconds <= 0) {
            return 0.0;
        }

        $weightedSum = 0.0;
        $currentBalance = $openingBalance;
        $currentTime = $start;

        foreach ($transactionsInPeriodAsc as $transaction) {
            $postedAt = $transaction->posted_at;

            if ($postedAt->lessThanOrEqualTo($currentTime)) {
                $currentBalance = (float) $transaction->{$balanceKey};

                continue;
            }

            $weightedSum += $currentBalance * $currentTime->diffInSeconds($postedAt);
            $currentBalance = (float) $transaction->{$balanceKey};
            $currentTime = $postedAt;
        }

        $weightedSum += $currentBalance * $currentTime->diffInSeconds($end);

        return round($weightedSum / $totalSeconds, 2);
    }
}
