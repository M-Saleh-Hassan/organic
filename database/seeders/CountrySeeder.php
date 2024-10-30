<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Country::count() > 0) return ;
        //https://github.com/dr5hn/countries-states-cities-database
        $path = public_path('json/countries.json');
        $json = File::get($path);
        $data = json_decode($json, true); // Convert the JSON string into an array
        $countries = [];
        foreach ($data as $country) {
            $countries[] = [
                "id"         =>  $country['id'],
                "name"       =>  $country['name'],
                "iso_code"   =>  $country['iso2'],
                "created_at" => now(),
            ];
        }
        Country::insert($countries);
    }
}
