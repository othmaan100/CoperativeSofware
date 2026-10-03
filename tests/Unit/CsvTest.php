<?php

namespace Tests\Unit;

use App\Support\Csv;
use PHPUnit\Framework\TestCase;

class CsvTest extends TestCase
{
    public function test_header_strips_byte_order_mark_and_normalises_names(): void
    {
        $handle = fopen('php://memory', 'r+');
        fwrite($handle, "\xEF\xBB\xBFStaff_ID , Amount\nFCE1,100\n");
        rewind($handle);

        $this->assertSame(['staff_id', 'amount'], Csv::readHeader($handle));
    }

    public function test_dates_are_read_day_first_or_iso(): void
    {
        $this->assertSame('2025-07-01', Csv::parseDate('01/07/2025'));
        $this->assertSame('2025-07-01', Csv::parseDate('1/7/2025'));
        $this->assertSame('2025-07-01', Csv::parseDate('01-07-2025'));
        $this->assertSame('2025-06-01', Csv::parseDate('2025-06-01'));
    }

    public function test_impossible_or_unrecognised_dates_return_null(): void
    {
        $this->assertNull(Csv::parseDate('31/02/2025'));
        $this->assertNull(Csv::parseDate('13/13/2025'));
        $this->assertNull(Csv::parseDate('July 1st'));
        $this->assertNull(Csv::parseDate(''));
    }
}
