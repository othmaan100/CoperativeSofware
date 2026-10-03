<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('share_price_history', function (Blueprint $table) {
            $table->id();
            $table->decimal('unit_price', 14, 2);
            $table->date('effective_from');
            $table->foreignId('set_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('share_price_history');
    }
};
