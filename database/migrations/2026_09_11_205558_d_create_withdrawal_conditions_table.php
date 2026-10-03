<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawal_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('savings_product_id')->constrained();
            $table->enum('rule_type', [
                'minimum_balance',
                'minimum_membership_duration',
                'max_withdrawal_pct_of_balance',
                'cooling_period',
            ]);
            $table->string('value'); // interpreted per rule_type
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('last_edited_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawal_conditions');
    }
};
