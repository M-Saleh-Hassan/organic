<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Financial;
use Carbon\Carbon;

class FinancialSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $financial = Financial::create([
                'user_id' => $i % 3 + 1, // Rotate users 1, 2, 3
                'land_id' => $i, // Use the first 10 lands
                'file_path' => "financials/sample_financial_file.xlsx", // Single file path for all
            ]);

            // Generate 5 financial records
            $records = [];
            $baseDate = Carbon::now()->subMonths(5); // Start from 5 months ago
            $months = ['July', 'August', 'September', 'October', 'November'];

            foreach ($months as $index => $month) {
                $records[] = [
                    'month' => $month,
                    'date' => $baseDate->addMonth()->toDateString(),
                    'amount' => 52000 - ($index * 2000), // Decrease amount for variation
                ];
            }

            $financial->records()->createMany($records);
        }
    }
}
