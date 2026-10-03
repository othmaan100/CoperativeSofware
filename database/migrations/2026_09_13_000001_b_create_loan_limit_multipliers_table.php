<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_limit_multipliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_product_id')->constrained()->cascadeOnDelete();
            $table->decimal('multiplier', 5, 2);
            $table->date('effective_from');
            $table->foreignId('set_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_limit_multipliers');
    }
};
