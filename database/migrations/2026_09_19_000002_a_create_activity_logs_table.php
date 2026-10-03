<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('causer_id')->nullable()->constrained('users')->nullOnDelete();
            // Snapshot of the actor's name/email at the time of the action, so
            // the entry stays meaningful even if the user is later renamed or
            // removed — same snapshot principle used for rates elsewhere.
            $table->string('causer_name')->nullable();
            $table->string('causer_email')->nullable();
            $table->nullableMorphs('subject');
            $table->string('action');
            $table->string('description');
            $table->json('properties')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('action');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
