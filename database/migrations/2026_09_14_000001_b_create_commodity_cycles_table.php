<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commodity_cycles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('request_deadline');
            $table->string('status')->default('open');
            $table->unsignedInteger('tenure_months')->nullable();
            $table->unsignedInteger('moratorium_months')->nullable();
            $table->decimal('markup_admin_pct', 5, 2)->default(2.00);
            $table->decimal('markup_profit_pct', 5, 2)->default(8.00);
            $table->foreignId('opened_by')->constrained('users');
            $table->foreignId('priced_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('priced_at')->nullable();
            $table->foreignId('auditor_verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('auditor_verified_at')->nullable();
            $table->foreignId('store_approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('store_approved_at')->nullable();
            $table->foreignId('chairman_authorized_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('chairman_authorized_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commodity_cycles');
    }
};
