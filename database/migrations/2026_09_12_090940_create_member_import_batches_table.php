<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_import_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->string('file_path');
            $table->unsignedInteger('total_records')->nullable();
            $table->unsignedInteger('imported_count')->nullable();
            $table->enum('status', ['uploaded', 'validated', 'imported', 'failed'])->default('uploaded');
            // Parsed rows: [{staff_id, full_name, ..., matched, error, member_id}]
            $table->json('rows')->nullable();
            $table->timestamp('imported_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_import_batches');
    }
};
