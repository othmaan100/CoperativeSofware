<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Nullable: existing members predate this field and are not
            // retroactively required to have one — only new registrations
            // must supply it (enforced in RegisterApplication's validation).
            $table->string('staff_category')->nullable()->after('rank_grade');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('staff_category');
        });
    }
};
