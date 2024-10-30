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
        if(!User::exists()) {
            $user = User::create([
                'tenant_id'  => Tenant::where('name', 'test')->first()?->id,
                'role_id'    => Role::where('name', 'admin')->first()?->id,
                'first_name' => 'RXA',
                'last_name'  => 'Admin',
                'email'      => 'admin@rxa.com',
                'password'   => Hash::make('12345678'),
                'phone'      => '12345678',
                'company'    => 'RXA',
                'position'   => 'CEO'
            ]);

            $user->permissions()->attach(Permission::all()->pluck('id')->toArray());
        }
    }
}
