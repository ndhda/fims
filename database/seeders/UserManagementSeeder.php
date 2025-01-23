<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserManagementSeeder extends Seeder
{
    public function run()
    {
        DB::table('user_management')->insert([
            'user_id' => 'super_admin_001', // Adjust as per your PK structure
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password123'), // Hashed password
            'loa_code' => '1', // Assume '1' corresponds to super admin in `level_of_access`
            'role_id' => 'super_admin', // Corresponds to super admin in `role`
        ]);
    }
}
