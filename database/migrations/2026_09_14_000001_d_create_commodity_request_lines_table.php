<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commodity_request_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commodity_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('commodity_item_id')->nullable()->constrained('commodity_items')->nullOnDelete();
            $table->string('custom_item_text')->nullable();
            $table->decimal('quantity', 8, 2);
            $table->string('unit_basis');
            $table->decimal('fixed_unit_price', 14, 2)->nullable();
            $table->decimal('line_total', 14, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commodity_request_lines');
    }
};
