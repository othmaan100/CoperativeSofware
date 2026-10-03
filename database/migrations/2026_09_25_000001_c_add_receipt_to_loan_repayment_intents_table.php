<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loan_repayment_intents', function (Blueprint $table) {
            $table->string('receipt_path')->nullable()->after('note');
            $table->string('receipt_original_filename')->nullable()->after('receipt_path');
        });
    }

    public function down(): void
    {
        Schema::table('loan_repayment_intents', function (Blueprint $table) {
            $table->dropColumn(['receipt_path', 'receipt_original_filename']);
        });
    }
};
