<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('loan_product_id')->constrained();
            $table->string('loan_no')->unique();
            $table->decimal('principal_amount', 14, 2);
            $table->decimal('interest_admin_pct', 5, 2);
            $table->decimal('interest_profit_pct', 5, 2);
            $table->decimal('total_interest', 14, 2);
            $table->decimal('interest_admin_amount', 14, 2);
            $table->decimal('interest_profit_amount', 14, 2);
            $table->decimal('total_repayable', 14, 2);
            $table->unsignedInteger('tenure_months');
            $table->decimal('monthly_installment', 14, 2);
            $table->decimal('multiplier_applied', 5, 2)->nullable();
            $table->decimal('outstanding_balance', 14, 2)->default(0);
            $table->string('status')->default('pending');
            $table->timestamp('applied_at')->nullable();
            $table->foreignId('treasurer_reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('treasurer_reviewed_at')->nullable();
            $table->text('treasurer_note')->nullable();
            $table->foreignId('chairman_reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('chairman_reviewed_at')->nullable();
            $table->text('chairman_note')->nullable();
            $table->foreignId('disbursed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('disbursed_at')->nullable();
            $table->string('disbursement_method')->nullable();
            $table->string('disbursement_reference')->nullable();
            $table->boolean('is_legacy_import')->default(false);
            $table->timestamp('defaulted_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
