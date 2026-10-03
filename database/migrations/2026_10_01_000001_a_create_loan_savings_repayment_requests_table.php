<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_savings_repayment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('savings_account_id')->constrained();
            $table->decimal('amount', 14, 2);
            // pending -> approved (transfer posted) or declined — a single
            // Treasurer approval step both authorizes AND executes the
            // transfer, unlike the two-stage withdrawal-request flow.
            $table->string('status')->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('decline_reason')->nullable();
            // The two ledger entries posted atomically on approval — one
            // debiting the savings account, one crediting the loan. Foreign
            // keys are named explicitly below since the default auto-generated
            // name exceeds MySQL's 64-character identifier limit.
            $table->foreignId('savings_transaction_id')->nullable();
            $table->foreignId('loan_repayment_transaction_id')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->foreign('savings_transaction_id', 'lsrr_savings_txn_fk')->references('id')->on('savings_transactions')->nullOnDelete();
            $table->foreign('loan_repayment_transaction_id', 'lsrr_loan_repayment_txn_fk')->references('id')->on('loan_repayment_transactions')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_savings_repayment_requests');
    }
};
