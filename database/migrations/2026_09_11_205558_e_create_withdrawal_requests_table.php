<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('savings_account_id')->constrained();
            $table->decimal('requested_amount', 14, 2);
            $table->decimal('approved_amount', 14, 2)->nullable();
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_name');
            $table->text('reason')->nullable();
            $table->enum('status', [
                'pending',
                'treasurer_approved',
                'treasurer_rejected',
                'chairman_authorized',
                'chairman_declined',
                'disbursed',
                'cancelled',
            ])->default('pending');
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
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};
