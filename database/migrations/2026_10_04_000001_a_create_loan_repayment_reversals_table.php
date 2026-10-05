<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The excess of a loan repayment over what the loan still owed. The
     * excess is reversed out of the loan ledger and tracked here until the
     * member chooses to apply it to another loan or have it refunded, and
     * the Treasurer processes that choice.
     */
    public function up(): void
    {
        Schema::create('loan_repayment_reversals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('loan_id')->constrained();
            $table->unsignedBigInteger('repayment_transaction_id');
            $table->unsignedBigInteger('reversal_transaction_id');
            $table->decimal('amount', 14, 2);
            $table->string('status')->default('awaiting_choice');
            $table->string('resolution')->nullable();
            $table->unsignedBigInteger('target_loan_id')->nullable();
            $table->unsignedBigInteger('applied_transaction_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->string('refund_reference')->nullable();
            $table->timestamp('chosen_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->foreign('repayment_transaction_id', 'lrr_repayment_txn_fk')->references('id')->on('loan_repayment_transactions');
            $table->foreign('reversal_transaction_id', 'lrr_reversal_txn_fk')->references('id')->on('loan_repayment_transactions');
            $table->foreign('target_loan_id', 'lrr_target_loan_fk')->references('id')->on('loans');
            $table->foreign('applied_transaction_id', 'lrr_applied_txn_fk')->references('id')->on('loan_repayment_transactions');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_repayment_reversals');
    }
};
