<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reversal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('original_transaction_id')->constrained('savings_transactions');
            $table->text('reason');
            $table->foreignId('initiated_by')->constrained('users');
            $table->foreignId('authorized_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['pending', 'authorized', 'declined', 'applied'])->default('pending');
            $table->text('decline_reason')->nullable();
            $table->foreignId('resulting_transaction_id')->nullable()->constrained('savings_transactions')->nullOnDelete();
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('authorized_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reversal_requests');
    }
};
