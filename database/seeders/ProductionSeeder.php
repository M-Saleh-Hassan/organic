<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Production;

class ProductionSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $production = Production::create([
                'user_id' => $i % 3 + 1, // Rotate users 1, 2, 3
                'land_id' => $i, // Use the first 10 lands
                'description' => "General production $i",
            ]);

            // Add 3 past details
            for ($j = 1; $j <= 3; $j++) {
                $production->details()->create([
                    'type' => 'past',
                    'text' => "Past production detail $j for production $i",
                    'order' => $j,
                ]);
            }

            // Add 3 current details
            for ($j = 1; $j <= 3; $j++) {
                $production->details()->create([
                    'type' => 'current',
                    'text' => "Current production detail $j for production $i",
                    'order' => $j,
                ]);
            }
        }
    }
}
