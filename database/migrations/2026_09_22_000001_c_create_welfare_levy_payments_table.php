<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('welfare_levy_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('welfare_levy_batch_id')->constrained();
            $table->foreignId('member_id')->constrained();
            $table->string('period'); // e.g. 2026-09
            $table->decimal('amount', 14, 2);
            $table->timestamp('posted_at');
            $table->timestamps();

            // A member can only be recorded as having paid the levy once per period.
            $table->unique(['member_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('welfare_levy_payments');
    }
};
