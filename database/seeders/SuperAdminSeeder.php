<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Ensure the super_admin role exists in the roles table
        $role = DB::table('roles')->where('role_name', 'super_admin')->first();

        if (!$role) {
            throw new \Exception('Super Admin role not found. Run the RoleSeeder first.');
        }

        // Insert Level of Access
        DB::table('level_of_access')->insertOrIgnore([
            'loa_code' => '1',
            'loa_name' => 'Super Admin Access',
        ]);

        // Insert Super Admin User
        DB::table('user_management')->insert([
            'email' => 'nadirahuda@gmail.com',
            'password' => Hash::make('password'),
            'loa_code' => '1',
            'role_id' => $role->role_id, // Use the role_id of the super_admin
        ]);
    }
}
