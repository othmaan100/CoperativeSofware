<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commodity_items', function (Blueprint $table) {
            $table->foreignId('created_from_request_line_id')->nullable()->after('is_active')
                ->constrained('commodity_request_lines')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('commodity_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_from_request_line_id');
        });
    }
};
