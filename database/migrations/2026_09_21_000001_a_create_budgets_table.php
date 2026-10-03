<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            // Identified by the calendar year its first month falls in —
            // same convention as App\Support\FinancialYear.
            $table->unsignedSmallInteger('fy_start_year')->unique();
            // draft -> pending_approval -> approved
            $table->string('status')->default('draft');
            $table->foreignId('proposed_by')->constrained('users');
            $table->timestamp('proposed_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
