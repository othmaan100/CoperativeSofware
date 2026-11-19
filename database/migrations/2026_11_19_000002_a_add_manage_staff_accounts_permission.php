<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Lets the Secretary and Treasurer correct staff members' Staff IDs and reset
 * their passwords (Staff Accounts page). Also in RolesAndPermissionsSeeder;
 * the live server gets it from database/sql/2026_11_19_staff_accounts_permission.sql.
 */
return new class extends Migration
{
    public function up(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $permission = Permission::findOrCreate('manage_staff_accounts', 'web');
        foreach (['secretary', 'treasurer', 'super_admin'] as $roleName) {
            Role::query()->where('name', $roleName)->where('guard_name', 'web')->first()?->givePermissionTo($permission);
        }
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Permission::query()->where('name', 'manage_staff_accounts')->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
