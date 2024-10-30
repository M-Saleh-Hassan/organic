<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (City::count() > 0) {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            City::truncate();
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        //https://github.com/dr5hn/countries-states-cities-database
        $path = public_path('json/cities.json');
        $json = File::get($path);
        $data = json_decode($json, true); // Convert the JSON string into an array
        $cities = [];
        echo "Processing cities: " . count($data) . "\n";
        $count = 0;
        foreach ($data as &$city) {
            $cities[] = [
                "id"         =>  $city['id'],
                "country_id" =>  $city['country_id'] ?? null,
                "name"       =>  $city['name'],
                "latitude"   =>  $city['latitude'],
                "longitude"  =>  $city['longitude'],
                "created_at" => now(),
            ];
            echo "Processing city: " . $count++ . "\n";
            if (count($cities) >= 1000) {
                City::insert($cities);
                $cities = [];
            }
        }
        if (count($cities) > 0) {
            City::insert($cities);
        }
    }
}
