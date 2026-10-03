<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_repayment_batches', function (Blueprint $table) {
            $table->id();
            $table->string('period');
            $table->foreignId('uploaded_by')->constrained('users');
            $table->string('file_path');
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->unsignedInteger('total_records')->default(0);
            $table->string('status')->default('validated');
            $table->json('rows')->nullable();
            $table->json('validation_errors')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_repayment_batches');
    }
};
