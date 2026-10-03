<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dividend_periods', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->date('fy_start_date');
            $table->date('fy_end_date');
            // open -> declared -> calculated -> posted
            $table->string('status')->default('open');

            $table->decimal('share_dividend_rate_pct', 5, 2)->nullable();
            $table->decimal('savings_interest_rate_pct', 5, 2)->nullable();

            // Loan interest profit (commodity loans included) + registration
            // fee profit booked within [fy_start_date, fy_end_date], captured
            // at declare-time purely as an advisory reference figure.
            $table->decimal('distributable_profit_snapshot', 14, 2)->nullable();

            $table->decimal('total_share_dividend_amount', 14, 2)->nullable();
            $table->decimal('total_savings_interest_amount', 14, 2)->nullable();

            $table->foreignId('opened_by')->constrained('users');
            $table->foreignId('declared_by')->nullable()->constrained('users');
            $table->timestamp('declared_at')->nullable();
            $table->foreignId('calculated_by')->nullable()->constrained('users');
            $table->timestamp('calculated_at')->nullable();
            $table->foreignId('posted_by')->nullable()->constrained('users');
            $table->timestamp('posted_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dividend_periods');
    }
};
