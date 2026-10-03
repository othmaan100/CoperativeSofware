<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commodity_cycle_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commodity_cycle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('commodity_item_id')->nullable()->constrained('commodity_items')->nullOnDelete();
            $table->string('custom_item_text')->nullable();
            $table->decimal('unit_price', 14, 2);
            $table->foreignId('set_by')->constrained('users');
            $table->timestamp('set_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commodity_cycle_prices');
    }
};
