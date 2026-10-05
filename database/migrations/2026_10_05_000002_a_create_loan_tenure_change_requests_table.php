<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A Treasurer's request to lengthen an active loan's tenure. The Chairman
     * approves or declines it; on approval the loan's remaining balance is
     * re-spread over the extra months and the monthly installment drops.
     */
    public function up(): void
    {
        Schema::create('loan_tenure_change_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained();
            $table->foreignId('member_id')->constrained();
            $table->unsignedSmallInteger('current_tenure_months');
            $table->unsignedSmallInteger('requested_tenure_months');
            $table->decimal('current_installment', 14, 2);
            $table->decimal('proposed_installment', 14, 2);
            $table->decimal('applied_installment', 14, 2)->nullable();
            $table->text('reason');
            $table->string('status')->default('pending');
            $table->foreignId('requested_by')->constrained('users');
            $table->timestamp('requested_at');
            $table->unsignedBigInteger('chairman_reviewed_by')->nullable();
            $table->timestamp('chairman_reviewed_at')->nullable();
            $table->text('chairman_note')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->foreign('chairman_reviewed_by', 'ltcr_chairman_fk')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_tenure_change_requests');
    }
};
