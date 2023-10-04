<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions for app
        $permissions = [
            'list-users',
            'create-users',
            'show-users',
            'update-users',
            'delete-users',
        ];

        foreach ($permissions as $permission) {
            \App\Models\Permission::create([
                'name' => $permission,
                'slug' => $permission,
            ]);
        }
    }
}
