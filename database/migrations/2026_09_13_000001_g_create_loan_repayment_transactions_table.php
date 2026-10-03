<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_repayment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained('loan_repayment_schedules')->nullOnDelete();
            $table->string('type');
            $table->decimal('amount', 14, 2);
            $table->decimal('balance_after', 14, 2);
            $table->string('reference')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('source_batch_id')->nullable()->constrained('loan_repayment_batches')->nullOnDelete();
            $table->foreignId('reversed_transaction_id')->nullable()->constrained('loan_repayment_transactions')->nullOnDelete();
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('posted_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_repayment_transactions');
    }
};
