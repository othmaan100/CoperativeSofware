<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commodity_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commodity_cycle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('loan_id')->nullable()->constrained('loans')->nullOnDelete();
            $table->decimal('commodity_subtotal', 14, 2)->nullable();
            $table->decimal('markup_amount', 14, 2)->nullable();
            $table->decimal('total_repayable', 14, 2)->nullable();
            $table->decimal('monthly_installment', 14, 2)->nullable();
            $table->boolean('salary_deduction_authorized')->default(false);
            $table->string('status')->default('submitted');
            $table->foreignId('released_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('released_at')->nullable();
            $table->timestamps();

            $table->unique(['commodity_cycle_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commodity_requests');
    }
};
