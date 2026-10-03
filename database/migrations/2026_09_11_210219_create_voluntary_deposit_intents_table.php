<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voluntary_deposit_intents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('savings_account_id')->constrained();
            $table->decimal('amount', 14, 2);
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'declined'])->default('pending');
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('confirmed_at')->nullable();
            $table->text('decline_reason')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained('savings_transactions')->nullOnDelete();
            $table->timestamp('requested_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voluntary_deposit_intents');
    }
};
