<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Profit earned in the legacy (pre-system / manual) records, entered by the
 * Treasurer against a dividend period. It is added to the profit this system
 * tracks itself when judging how much the declared rates can pay out.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dividend_legacy_profits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dividend_period_id')->constrained('dividend_periods')->cascadeOnDelete();
            $table->string('category'); // loan_interest | registration_fees | commodity_markup | other_income
            $table->decimal('amount', 14, 2);
            $table->string('description')->nullable();
            $table->foreignId('entered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dividend_legacy_profits');
    }
};
