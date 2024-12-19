<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $contracts = [
            ['user_id' => 1, 'land_id' => 1, 'sponsorship_contract_path' => 'contracts/sponsorship_contract_1.pdf', 'participation_contract_path' => 'contracts/participation_contract_1.pdf', 'personal_id_path' => 'contracts/personal_id_1.pdf'],
            ['user_id' => 2, 'land_id' => 2, 'sponsorship_contract_path' => 'contracts/sponsorship_contract_2.pdf', 'participation_contract_path' => 'contracts/participation_contract_2.pdf', 'personal_id_path' => 'contracts/personal_id_2.pdf'],
            ['user_id' => 3, 'land_id' => 3, 'sponsorship_contract_path' => 'contracts/sponsorship_contract_3.pdf', 'participation_contract_path' => 'contracts/participation_contract_3.pdf', 'personal_id_path' => 'contracts/personal_id_3.pdf'],
            ['user_id' => 1, 'land_id' => 4, 'sponsorship_contract_path' => 'contracts/sponsorship_contract_1.pdf', 'participation_contract_path' => 'contracts/participation_contract_1.pdf', 'personal_id_path' => 'contracts/personal_id_1.pdf'],
            ['user_id' => 2, 'land_id' => 5, 'sponsorship_contract_path' => 'contracts/sponsorship_contract_2.pdf', 'participation_contract_path' => 'contracts/participation_contract_2.pdf', 'personal_id_path' => 'contracts/personal_id_2.pdf'],
            ['user_id' => 3, 'land_id' => 6, 'sponsorship_contract_path' => 'contracts/sponsorship_contract_3.pdf', 'participation_contract_path' => 'contracts/participation_contract_3.pdf', 'personal_id_path' => 'contracts/personal_id_3.pdf'],
            ['user_id' => 1, 'land_id' => 7, 'sponsorship_contract_path' => 'contracts/sponsorship_contract_1.pdf', 'participation_contract_path' => 'contracts/participation_contract_1.pdf', 'personal_id_path' => 'contracts/personal_id_1.pdf'],
            ['user_id' => 2, 'land_id' => 8, 'sponsorship_contract_path' => 'contracts/sponsorship_contract_2.pdf', 'participation_contract_path' => 'contracts/participation_contract_2.pdf', 'personal_id_path' => 'contracts/personal_id_2.pdf'],
            ['user_id' => 3, 'land_id' => 9, 'sponsorship_contract_path' => 'contracts/sponsorship_contract_3.pdf', 'participation_contract_path' => 'contracts/participation_contract_3.pdf', 'personal_id_path' => 'contracts/personal_id_3.pdf'],
            ['user_id' => 1, 'land_id' => 10, 'sponsorship_contract_path' => 'contracts/sponsorship_contract_1.pdf', 'participation_contract_path' => 'contracts/participation_contract_1.pdf', 'personal_id_path' => 'contracts/personal_id_1.pdf'],
        ];

        foreach ($contracts as $contract) {
            Contract::create($contract);
        }
    }
}
