<?php

namespace App\Support;

class Csv
{
    /**
     * Read the header row as lowercase, trimmed column names. Strips the
     * UTF-8 byte-order mark Excel adds when saving as "CSV UTF-8", which
     * would otherwise glue itself to the first column name.
     */
    public static function readHeader($handle): array
    {
        $header = fgetcsv($handle) ?: [];

        if (isset($header[0])) {
            $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', (string) $header[0]);
        }

        return array_map(fn ($h) => strtolower(trim((string) $h)), $header);
    }

    /**
     * Parse an uploaded date into Y-m-d, or null if it isn't a real date.
     * Slashed dates are read day-first (01/07/2025 = 1 July 2025), as written
     * in Nigeria — PHP's own parsing would read that as 7 January.
     */
    public static function parseDate(string $value): ?string
    {
        $value = trim($value);

        if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value, $m)) {
            [$year, $month, $day] = [(int) $m[1], (int) $m[2], (int) $m[3]];
        } elseif (preg_match('#^(\d{1,2})[/.-](\d{1,2})[/.-](\d{4})$#', $value, $m)) {
            [$day, $month, $year] = [(int) $m[1], (int) $m[2], (int) $m[3]];
        } else {
            return null;
        }

        return checkdate($month, $day, $year) ? sprintf('%04d-%02d-%02d', $year, $month, $day) : null;
    }
}
