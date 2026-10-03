<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('application_fee_source')->nullable()->after('application_fee_paid_at');
            $table->foreignId('application_fee_marked_by')->nullable()->after('application_fee_source')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropConstrainedForeignId('application_fee_marked_by');
            $table->dropColumn('application_fee_source');
        });
    }
};
