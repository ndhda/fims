<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert roles into the roles table
        Role::create(['role_name' => 'super_admin']);
        Role::create(['role_name' => 'admin']);
        Role::create(['role_name' => 'student']);
    }
}
