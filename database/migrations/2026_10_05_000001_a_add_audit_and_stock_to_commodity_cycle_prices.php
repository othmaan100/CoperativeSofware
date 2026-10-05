<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Each cycle price row is one item in the cycle. It now also carries:
     *  - the Auditor's price correction (original Secretary price kept), and
     *  - the Store Officer's verified count of what is in the store.
     * Release is capped at the verified good-condition quantity.
     */
    public function up(): void
    {
        Schema::table('commodity_cycle_prices', function (Blueprint $table) {
            $table->decimal('original_unit_price', 14, 2)->nullable()->after('unit_price');
            $table->unsignedBigInteger('revised_by')->nullable()->after('set_at');
            $table->timestamp('revised_at')->nullable()->after('revised_by');
            $table->decimal('quantity_in_store', 10, 2)->nullable()->after('revised_at');
            $table->decimal('quantity_damaged', 10, 2)->nullable()->after('quantity_in_store');

            $table->foreign('revised_by', 'ccp_revised_by_fk')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('commodity_request_lines', function (Blueprint $table) {
            $table->string('shortfall_reason')->nullable()->after('released_line_total');
        });
    }

    public function down(): void
    {
        Schema::table('commodity_request_lines', function (Blueprint $table) {
            $table->dropColumn('shortfall_reason');
        });

        Schema::table('commodity_cycle_prices', function (Blueprint $table) {
            $table->dropForeign('ccp_revised_by_fk');
            $table->dropColumn(['original_unit_price', 'revised_by', 'revised_at', 'quantity_in_store', 'quantity_damaged']);
        });
    }
};
