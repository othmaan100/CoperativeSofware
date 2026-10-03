<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contribution_batches', function (Blueprint $table) {
            $table->id();
            $table->string('period'); // e.g. 2026-09
            $table->foreignId('uploaded_by')->constrained('users');
            $table->string('file_path');
            $table->decimal('total_amount', 14, 2)->nullable();
            $table->unsignedInteger('total_records')->nullable();
            $table->enum('status', ['uploaded', 'validated', 'posted', 'failed'])->default('uploaded');
            // Parsed rows for this batch: [{staff_id, amount, member_id, matched, error}]
            $table->json('rows')->nullable();
            $table->json('validation_errors')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contribution_batches');
    }
};
