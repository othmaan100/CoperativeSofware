<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_guarantors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guarantor_member_id')->constrained('members');
            $table->decimal('pledged_amount', 14, 2);
            $table->string('status')->default('invited');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('declined_at')->nullable();
            $table->timestamp('called_at')->nullable();
            $table->foreignId('deduction_transaction_id')->nullable()->constrained('savings_transactions')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_guarantors');
    }
};
