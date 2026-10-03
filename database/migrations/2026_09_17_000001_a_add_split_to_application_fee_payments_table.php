<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('application_fee_payments', function (Blueprint $table) {
            // Distinguishes how the payment was recorded — 'paystack', 'manual',
            // or 'legacy_import' — separate from `channel`, which is Paystack's
            // own payment channel (card, bank_transfer, ussd, ...).
            $table->string('source')->nullable()->after('channel');
            $table->decimal('admin_pct', 5, 2)->nullable()->after('source');
            $table->decimal('profit_pct', 5, 2)->nullable()->after('admin_pct');
            $table->decimal('admin_amount', 14, 2)->nullable()->after('profit_pct');
            $table->decimal('profit_amount', 14, 2)->nullable()->after('admin_amount');
            $table->foreignId('recorded_by')->nullable()->after('profit_amount')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('application_fee_payments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('recorded_by');
            $table->dropColumn(['source', 'admin_pct', 'profit_pct', 'admin_amount', 'profit_amount']);
        });
    }
};
