<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commodity_items', function (Blueprint $table) {
            // The set of ways a member may request this item (e.g. "Full bag",
            // "Half bag", "Quarter bag") — distinct from pack_unit, which
            // describes the item's own standard pack size. Null/empty means
            // no fixed list has been defined yet, so the request form falls
            // back to free-text entry for that item.
            $table->json('unit_options')->nullable()->after('pack_unit');
        });
    }

    public function down(): void
    {
        Schema::table('commodity_items', function (Blueprint $table) {
            $table->dropColumn('unit_options');
        });
    }
};
