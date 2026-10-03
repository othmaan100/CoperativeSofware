<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_import_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->string('file_path');
            $table->unsignedInteger('total_records')->default(0);
            $table->unsignedInteger('imported_count')->nullable();
            $table->string('status')->default('validated');
            $table->json('rows')->nullable();
            $table->timestamp('imported_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_import_batches');
    }
};
