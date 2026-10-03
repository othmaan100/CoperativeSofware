<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->enum('type', ['partial', 'complete'])->default('partial')->after('savings_account_id');
            $table->enum('beneficiary_type', ['member', 'next_of_kin'])->default('member')->after('type');
            $table->foreignId('initiated_by')->nullable()->after('beneficiary_type')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('initiated_by');
            $table->dropColumn(['type', 'beneficiary_type']);
        });
    }
};
