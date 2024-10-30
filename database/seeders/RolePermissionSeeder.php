<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Role::where('name', 'subcontractor')->exists()) {
            $roles = [
                'admin',
                'subcontractor',
                'builder'
            ];
            foreach ($roles as $role) {
                Role::create([
                    'name' => $role,
                ]);
            }
        }
        if(!Permission::exists()) {
            $permissions = [
                'dashboard',
                'projects',
                'defects',
                'floor_plans',
                'site_diaries',
                'reports',
                'users'
            ];
            foreach ($permissions as $permission) {
                Permission::create([
                    'name' => $permission,
                ]);
            }
        }
    }
}
