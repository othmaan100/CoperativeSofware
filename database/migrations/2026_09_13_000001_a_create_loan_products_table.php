<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->decimal('interest_admin_pct', 5, 2)->default(2.00);
            $table->decimal('interest_profit_pct', 5, 2)->default(8.00);
            $table->unsignedInteger('max_tenure_months');
            $table->unsignedInteger('min_membership_months')->default(0);
            $table->decimal('min_savings_balance', 14, 2)->default(0);
            $table->boolean('requires_guarantor')->default(true);
            $table->unsignedTinyInteger('min_guarantors')->nullable();
            $table->unsignedTinyInteger('max_guarantors')->nullable();
            $table->string('disbursement_type')->default('cash_or_bank');
            $table->unsignedInteger('default_after_days_overdue')->default(30);
            $table->unsignedInteger('guarantor_grace_days')->default(7);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_products');
    }
};
