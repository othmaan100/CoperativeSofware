<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Members may only apply for a loan product while the Treasurer has opened
 * applications for it. Separate from `is_active` (whether the product exists
 * at all, which loan imports also rely on). Every product starts closed.
 *
 * The permission is created here as well as in RolesAndPermissionsSeeder,
 * because deploys only upload files — running `php artisan migrate` on the
 * server is then the single step needed to switch this on.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loan_products', function (Blueprint $table) {
            $table->boolean('applications_open')->default(false)->after('is_active');
            // Last day (inclusive) applications are accepted; null = open until closed by hand.
            $table->date('applications_close_on')->nullable()->after('applications_open');
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $permission = Permission::findOrCreate('open_loan_applications', 'web');
        foreach (['treasurer', 'super_admin'] as $roleName) {
            Role::query()->where('name', $roleName)->where('guard_name', 'web')->first()?->givePermissionTo($permission);
        }
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Permission::query()->where('name', 'open_loan_applications')->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        Schema::table('loan_products', function (Blueprint $table) {
            $table->dropColumn(['applications_open', 'applications_close_on']);
        });
    }
};
