<?php

namespace Database\Seeders;

use App\Models\Land;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $lands = [
            ['user_id' => 1, 'land_number' => '283', 'size' => 5.00, 'number_of_pits' => 300, 'number_of_palms' => 300, 'cultivation_count' => '2024', 'missing_count' => 50.00],
            ['user_id' => 2, 'land_number' => '100', 'size' => 3.50, 'number_of_pits' => 200, 'number_of_palms' => 180, 'cultivation_count' => '2023', 'missing_count' => 25.00],
            ['user_id' => 3, 'land_number' => '101', 'size' => 8.00, 'number_of_pits' => 400, 'number_of_palms' => 380, 'cultivation_count' => '2024', 'missing_count' => 20.00],
            ['user_id' => 1, 'land_number' => '102', 'size' => 6.00, 'number_of_pits' => 320, 'number_of_palms' => 300, 'cultivation_count' => '2022', 'missing_count' => 30.00],
            ['user_id' => 2, 'land_number' => '103', 'size' => 7.50, 'number_of_pits' => 350, 'number_of_palms' => 330, 'cultivation_count' => '2021', 'missing_count' => 40.00],
            ['user_id' => 3, 'land_number' => '104', 'size' => 4.75, 'number_of_pits' => 220, 'number_of_palms' => 200, 'cultivation_count' => '2023', 'missing_count' => 15.00],
            ['user_id' => 1, 'land_number' => '105', 'size' => 5.50, 'number_of_pits' => 300, 'number_of_palms' => 280, 'cultivation_count' => '2020', 'missing_count' => 35.00],
            ['user_id' => 2, 'land_number' => '106', 'size' => 9.00, 'number_of_pits' => 450, 'number_of_palms' => 420, 'cultivation_count' => '2019', 'missing_count' => 50.00],
            ['user_id' => 3, 'land_number' => '107', 'size' => 2.50, 'number_of_pits' => 120, 'number_of_palms' => 100, 'cultivation_count' => '2021', 'missing_count' => 10.00],
            ['user_id' => 1, 'land_number' => '108', 'size' => 6.25, 'number_of_pits' => 330, 'number_of_palms' => 310, 'cultivation_count' => '2022', 'missing_count' => 45.00],
        ];

        foreach ($lands as $land) {
            Land::create($land);
        }
    }
}
