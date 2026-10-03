<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_repayment_intents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained();
            $table->decimal('amount', 14, 2);
            $table->text('note')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('confirmed_at')->nullable();
            $table->text('decline_reason')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained('loan_repayment_transactions')->nullOnDelete();
            $table->timestamp('requested_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_repayment_intents');
    }
};
