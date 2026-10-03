<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('share_withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('share_account_id')->constrained();
            $table->unsignedInteger('shares_requested');
            $table->unsignedInteger('shares_approved')->nullable();
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_name');
            $table->text('reason')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('treasurer_reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('treasurer_reviewed_at')->nullable();
            $table->text('treasurer_note')->nullable();
            $table->foreignId('chairman_reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('chairman_reviewed_at')->nullable();
            $table->text('chairman_note')->nullable();
            $table->foreignId('disbursed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('disbursed_at')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->timestamps();
        });

        Schema::table('share_transactions', function (Blueprint $table) {
            $table->foreign('withdrawal_request_id')->references('id')->on('share_withdrawal_requests')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('share_transactions', function (Blueprint $table) {
            $table->dropForeign(['withdrawal_request_id']);
        });

        Schema::dropIfExists('share_withdrawal_requests');
    }
};
