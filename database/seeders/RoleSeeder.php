<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles

        // Admin
        $admin = \App\Models\Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);

        // User
        $user = \App\Models\Role::create([
            'name' => 'User',
            'slug' => 'user',
        ]);
    }
}
