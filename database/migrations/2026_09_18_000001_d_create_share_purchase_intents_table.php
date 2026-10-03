<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('share_purchase_intents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('share_account_id')->constrained();
            $table->unsignedInteger('shares_requested');
            $table->text('note')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('confirmed_at')->nullable();
            $table->text('decline_reason')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained('share_transactions')->nullOnDelete();
            $table->timestamp('requested_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('share_purchase_intents');
    }
};
