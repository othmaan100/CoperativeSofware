<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * What the Store Officer actually handed over, per line. The requested
     * quantity/line_total stay as the record of what the member asked for;
     * the member's loan is built from the released values only.
     */
    public function up(): void
    {
        Schema::table('commodity_request_lines', function (Blueprint $table) {
            $table->decimal('quantity_released', 8, 2)->nullable()->after('line_total');
            $table->decimal('released_line_total', 14, 2)->nullable()->after('quantity_released');
        });

        // Requests released before this change handed over everything requested.
        DB::table('commodity_request_lines')
            ->whereIn('commodity_request_id', DB::table('commodity_requests')->where('status', 'active')->select('id'))
            ->update([
                'quantity_released' => DB::raw('quantity'),
                'released_line_total' => DB::raw('line_total'),
            ]);
    }

    public function down(): void
    {
        Schema::table('commodity_request_lines', function (Blueprint $table) {
            $table->dropColumn(['quantity_released', 'released_line_total']);
        });
    }
};
