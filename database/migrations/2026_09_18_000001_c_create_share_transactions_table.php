<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('share_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('share_account_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->integer('shares_delta');
            $table->decimal('unit_price_applied', 14, 2);
            $table->decimal('amount', 14, 2);
            $table->unsignedInteger('shares_after');
            $table->decimal('balance_after', 14, 2);
            $table->string('reference')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('source_batch_id')->nullable()->constrained('contribution_batches')->nullOnDelete();
            $table->foreignId('withdrawal_request_id')->nullable();
            $table->foreignId('reversed_transaction_id')->nullable()->constrained('share_transactions')->nullOnDelete();
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('posted_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('share_transactions');
    }
};
