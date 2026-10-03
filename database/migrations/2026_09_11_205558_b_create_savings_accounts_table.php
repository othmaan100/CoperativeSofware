<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('savings_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('savings_product_id')->constrained();
            $table->string('account_no')->unique();
            $table->decimal('target_amount', 14, 2)->nullable();
            $table->date('target_date')->nullable();
            $table->decimal('balance', 14, 2)->default(0);
            $table->enum('status', ['active', 'closed'])->default('active');
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->unique(['member_id', 'savings_product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('savings_accounts');
    }
};
