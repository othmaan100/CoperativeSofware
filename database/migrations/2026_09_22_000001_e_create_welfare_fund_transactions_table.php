<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('welfare_fund_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('welfare_fund_id')->constrained();
            // levy (credit) or payout (debit) — governed by
            // WelfareFund::CREDIT_TYPES, not an enum, to match the
            // convention already used on savings_transactions.
            $table->string('type');
            $table->decimal('amount', 14, 2);
            $table->decimal('balance_after', 14, 2);
            $table->text('description')->nullable();
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('posted_at');
            $table->foreignId('source_batch_id')->nullable()->constrained('welfare_levy_batches')->nullOnDelete();
            $table->foreignId('claim_id')->nullable()->constrained('welfare_claims')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('welfare_fund_transactions');
    }
};
