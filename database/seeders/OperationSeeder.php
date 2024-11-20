<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operation;

class OperationSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $operation = Operation::create([
                'user_id' => $i % 3 + 1, // Rotate users 1, 2, 3
                'land_id' => $i, // Use the first 10 lands
                'description' => "General operation $i",
            ]);

            // Add 3 past details
            for ($j = 1; $j <= 3; $j++) {
                $operation->details()->create([
                    'type' => 'past',
                    'description' => "Past detail $j for operation $i",
                    'order' => $j,
                ]);
            }

            // Add 3 current details
            for ($j = 1; $j <= 3; $j++) {
                $operation->details()->create([
                    'type' => 'current',
                    'description' => "Current detail $j for operation $i",
                    'order' => $j,
                ]);
            }

            // Add 3 future details
            for ($j = 1; $j <= 3; $j++) {
                $operation->details()->create([
                    'type' => 'future',
                    'description' => "Future detail $j for operation $i",
                    'order' => $j,
                ]);
            }
        }
    }
}
