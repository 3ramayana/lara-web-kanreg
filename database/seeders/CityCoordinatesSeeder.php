<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CityCoordinatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Kabupaten Manokwari', 'lat' => -0.861453, 'lng' => 134.062042],
            ['name' => 'Kota Sorong', 'lat' => -0.876523, 'lng' => 131.255951],
            ['name' => 'Kabupaten Sorong', 'lat' => -1.0664, 'lng' => 131.5794],
            ['name' => 'Kabupaten Manokwari Selatan', 'lat' => -1.3323, 'lng' => 134.1287],
            ['name' => 'Kabupaten Pegunungan Arfak', 'lat' => -1.0921, 'lng' => 133.8760],
            ['name' => 'Kabupaten Teluk Bintuni', 'lat' => -2.1585, 'lng' => 133.5686],
            ['name' => 'Kabupaten Teluk Wondama', 'lat' => -2.7167, 'lng' => 134.4500],
            ['name' => 'Kabupaten Fakfak', 'lat' => -2.9238, 'lng' => 132.2965],
            ['name' => 'Kabupaten Kaimana', 'lat' => -3.6596, 'lng' => 133.7709],
            ['name' => 'Kabupaten Sorong Selatan', 'lat' => -1.5034, 'lng' => 132.0622],
            ['name' => 'Kabupaten Maybrat', 'lat' => -1.2721, 'lng' => 132.3276],
            ['name' => 'Kabupaten Tambrauw', 'lat' => -0.6698, 'lng' => 132.4839],
            ['name' => 'Kabupaten Raja Ampat', 'lat' => -0.2312, 'lng' => 130.5159],
        ];

        foreach ($cities as $city) {
            // First check if it exists by name to update coordinates
            $existing = \App\Models\City::where('name', $city['name'])->first();
            if ($existing) {
                $existing->update(['latitude' => $city['lat'], 'longitude' => $city['lng']]);
            } else {
                \App\Models\City::create([
                    'name' => $city['name'],
                    'slug' => \Illuminate\Support\Str::slug($city['name']),
                    'latitude' => $city['lat'],
                    'longitude' => $city['lng']
                ]);
            }
        }
    }
}
