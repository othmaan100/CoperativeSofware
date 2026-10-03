<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => 'admin@fcetpcoop.local'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('ChangeMe123!'),
                'email_verified_at' => now(),
            ]
        );

        if (! $user->hasRole('super_admin')) {
            $user->assignRole('super_admin');
        }
    }
}
