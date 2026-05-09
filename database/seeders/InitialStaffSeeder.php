<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class InitialStaffSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@example.local'],
            ['name' => 'Admin', 'role' => 'admin', 'password' => Hash::make('password')]
        );

        User::updateOrCreate(
            ['email' => 'staff@example.local'],
            ['name' => 'Staff', 'role' => 'staff', 'password' => Hash::make('password')]
        );

        User::updateOrCreate(
            ['email' => 'checker@example.local'],
            ['name' => 'Checker', 'role' => 'staff', 'password' => Hash::make('password')]
        );
    }
}
