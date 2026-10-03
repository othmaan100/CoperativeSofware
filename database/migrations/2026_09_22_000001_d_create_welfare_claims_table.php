<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('welfare_claims', function (Blueprint $table) {
            $table->id();
            $table->string('claim_no')->unique();
            $table->foreignId('member_id')->constrained();
            $table->date('date_of_death');
            $table->string('beneficiary_name');
            $table->string('beneficiary_relationship');
            $table->string('beneficiary_phone');
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            // Snapshot of the death_benefit_amount setting at the time the
            // claim was raised — later policy changes must not rewrite it.
            $table->decimal('amount', 14, 2);
            // pending -> chairman_authorized -> disbursed (or chairman_declined)
            $table->string('status')->default('pending');
            $table->foreignId('initiated_by')->constrained('users');
            $table->foreignId('chairman_reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('chairman_reviewed_at')->nullable();
            $table->text('chairman_note')->nullable();
            $table->foreignId('disbursed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('disbursed_at')->nullable();
            $table->string('payment_reference')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('welfare_claims');
    }
};
