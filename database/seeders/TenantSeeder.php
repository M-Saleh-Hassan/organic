<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Tenant::where('domain_name', 'test')->exists()) {
            Tenant::create([
                'name' => 'test',
                'domain_name' => 'test'
            ]);
        }
    }
}
