<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('savings_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('savings_account_id')->constrained();
            // A plain string rather than an enum: the set of transaction types is
            // governed by SavingsAccount::CREDIT_TYPES/DEBIT_TYPES and application
            // validation, so new types (e.g. opening_balance for migrated members)
            // don't require an ALTER TABLE.
            $table->string('type');
            $table->decimal('amount', 14, 2);
            $table->decimal('balance_after', 14, 2);
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('posted_at');
            $table->foreignId('source_batch_id')->nullable()->constrained('contribution_batches')->nullOnDelete();
            $table->foreignId('withdrawal_request_id')->nullable()->constrained('withdrawal_requests')->nullOnDelete();
            $table->foreignId('reversed_transaction_id')->nullable()->constrained('savings_transactions')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('savings_transactions');
    }
};
