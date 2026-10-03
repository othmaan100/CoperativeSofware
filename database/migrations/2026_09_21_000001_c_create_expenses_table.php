<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_no')->unique();
            $table->foreignId('budget_line_id')->constrained();
            $table->string('description');
            $table->decimal('amount', 14, 2);
            // pending -> chairman_authorized -> paid (or chairman_declined)
            $table->string('status')->default('pending');
            $table->foreignId('initiated_by')->constrained('users');
            $table->foreignId('chairman_reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('chairman_reviewed_at')->nullable();
            $table->text('chairman_note')->nullable();
            $table->foreignId('paid_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_reference')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
