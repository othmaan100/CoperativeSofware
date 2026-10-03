<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * These columns were required at the database level, but legacy/bulk
     * member imports don't always have this information on hand. They're
     * now nullable; members imported with gaps are prompted to fill them
     * in on first login (see EnsureProfileIsComplete).
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('phone_1')->nullable()->change();
            $table->enum('gender', ['male', 'female'])->nullable()->change();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->text('home_address')->nullable()->change();
            $table->string('department')->nullable()->change();
        });

        Schema::table('next_of_kin', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('relationship')->nullable()->change();
            $table->string('phone')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('phone_1')->nullable(false)->change();
            $table->enum('gender', ['male', 'female'])->nullable(false)->change();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable(false)->change();
            $table->date('date_of_birth')->nullable(false)->change();
            $table->text('home_address')->nullable(false)->change();
            $table->string('department')->nullable(false)->change();
        });

        Schema::table('next_of_kin', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('relationship')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
        });
    }
};
