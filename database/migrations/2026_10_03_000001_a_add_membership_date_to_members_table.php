<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The date a member actually joined the cooperative — distinct from
     * application_no/applied_at/approved_at, which record when the record
     * was created in this system (always "now" for a bulk legacy import).
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->date('membership_date')->nullable()->after('membership_no');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('membership_date');
        });
    }
};
