<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no')->unique();
            // The member the complaint concerns — not necessarily the same
            // person who raised it (a staff member can log one on a
            // member's behalf).
            $table->foreignId('member_id')->constrained();
            $table->foreignId('raised_by')->constrained('users');
            $table->string('category');
            $table->string('subject');
            $table->boolean('is_confidential')->default(false);
            // open -> in_progress -> resolved
            $table->string('status')->default('open');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'is_confidential']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
