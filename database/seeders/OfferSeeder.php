<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Option A: Create specific English records
        Offer::create([
            'title' => 'Exclusive Summer Sale',
            'description' => 'Get up to 50% off on all summer collections. Limited time offer!',
            'is_active' => true,
            'image_path' => 'https://picsum.photos/seed/summer/800/600',
            'company_id' => 1,
            'category_id' => 1,
        ]);

        Offer::create([
            'title' => 'Flash Deal: Tech Week',
            'description' => 'Huge discounts on the latest gadgets and accessories.',
            'is_active' => true,
            'image_path' => 'https://picsum.photos/seed/tech/800/600',
            'company_id' => 2,
            'category_id' => 2,
        ]);
        Offer::create([
            'title' => 'General Offer',
            'description' => 'This offer is not linked to any company',
            'image_path' => 'https://picsum.photos/seed/tech/800/600',

            'company_id' => null, // مسموح الآن
            'category_id' => null, // مسموح الآن
        ]);

        // Option B: Generate 10 random offers using a Factory
        // Offer::factory(10)->create();
    }
}
