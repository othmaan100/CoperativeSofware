<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            // Polymorphic owner — Member or Loan for now, extendable later
            // without a schema change.
            $table->morphs('documentable');
            $table->string('title');
            $table->string('file_path');
            $table->string('original_filename');
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
