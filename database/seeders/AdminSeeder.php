<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role_id' => 1, // Assuming 1 is the role ID for admin
            'full_name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone_number' => '12345678902',
            'id_type' => 'passport', // or 'national_id'
            'id_number' => 'A123456728',
            'password' => Hash::make('password'),
        ]);
    }
}
