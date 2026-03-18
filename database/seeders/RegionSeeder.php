<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $regions = [
            ['name' => 'Maadi', 'is_active' => true],
            ['name' => 'Nasr City', 'is_active' => true],
            ['name' => 'New Cairo', 'is_active' => true],
            ['name' => 'Zamalek', 'is_active' => true],
            ['name' => 'Sheikh Zayed', 'is_active' => true],
            ['name' => 'Heliopolis', 'is_active' => true],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}
