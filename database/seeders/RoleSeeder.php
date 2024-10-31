<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Role::where('name', 'client')->exists()) {
            $roles = [
                'admin',
                'client',
            ];
            foreach ($roles as $role) {
                Role::create([
                    'name' => $role,
                ]);
            }
        }
    }
}
