<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained()->cascadeOnDelete();
            $table->string('category');
            $table->decimal('budgeted_amount', 14, 2);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['budget_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_lines');
    }
};
