<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dividend_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dividend_period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained();

            $table->decimal('average_share_balance', 14, 2);
            $table->decimal('average_savings_balance', 14, 2);
            $table->decimal('share_rate_applied', 5, 2);
            $table->decimal('savings_rate_applied', 5, 2);
            $table->decimal('share_dividend_amount', 14, 2);
            $table->decimal('savings_interest_amount', 14, 2);

            // calculated -> posted
            $table->string('status')->default('calculated');
            $table->foreignId('dividend_transaction_id')->nullable()->constrained('savings_transactions');
            $table->foreignId('interest_transaction_id')->nullable()->constrained('savings_transactions');

            $table->timestamps();

            $table->unique(['dividend_period_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dividend_allocations');
    }
};
