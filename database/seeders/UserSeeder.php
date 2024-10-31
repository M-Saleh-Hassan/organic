<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(User::count() > 4) return ;
        $users = [
            [
                'full_name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'phone_number' => '1234567890',
                'id_type' => 'passport',
                'id_number' => 'A12345678',
                'password' => '12345678',
            ],
            [
                'full_name' => 'Dan Brown',
                'email' => 'dan.brown@example.com',
                'phone_number' => '0987654321',
                'id_type' => 'national_id',
                'id_number' => 'N987654321',
                'password' => '12345678',
            ],
            [
                'full_name' => 'Phil Jeffrey',
                'email' => 'phil.jeffrey@example.com',
                'phone_number' => '1122334455',
                'id_type' => 'passport',
                'id_number' => 'B11223344',
                'password' => '12345678',
            ],
            [
                'full_name' => 'Noah Hunt',
                'email' => 'noah.hunt@example.com',
                'phone_number' => '5566778899',
                'id_type' => 'national_id',
                'id_number' => 'N55667788',
                'password' => '12345678',
            ]
        ];
        foreach ($users as $data) {
            $user = User::create([
                'role_id'    => Role::where('name', 'client')->first()?->id,
                'full_name'  => $data['full_name'],
                'email'      => $data['email'],
                'password'   => Hash::make($data['password']),
                'phone_number' => $data['phone_number'],
                'id_type'    => $data['id_type'],
                'id_number'  => $data['id_number'],
            ]);
        }
    }
}
