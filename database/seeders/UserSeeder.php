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
                'first_name' => 'John',
                'last_name' => 'Smith',
                'position' => 'Painter',
            ],
            [
                'first_name' => 'Dan',
                'last_name' => 'Brown',
                'position' => 'Electrian',
            ],
            [
                'first_name' => 'Phil',
                'last_name' => 'Jeffrey',
                'position' => 'Plumber',
            ],
            [
                'first_name' => 'Noah',
                'last_name' => 'Hunt',
                'position' => 'Carpenter',
            ]
        ];
        foreach ($users as $data) {
            $user = User::create([
                'tenant_id'  => Tenant::where('name', 'test')->first()?->id,
                'role_id'    => Role::where('name', 'subcontractor')->first()?->id,
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'email'      => $data['first_name'].'@rxa.com',
                'password'   => Hash::make('12345678'),
                'phone'      => '12345678',
                'company'    => 'RXA',
                'position'   => $data['position'],
            ]);

            $user->permissions()->attach(Permission::all()->pluck('id')->toArray());
        }
    }
}
