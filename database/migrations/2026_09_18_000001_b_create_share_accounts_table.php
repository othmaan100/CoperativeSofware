<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('share_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->unique()->constrained();
            $table->string('account_no')->unique();
            $table->unsignedInteger('total_shares')->default(0);
            $table->decimal('balance', 14, 2)->default(0);
            $table->string('status')->default('active');
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('share_accounts');
    }
};
