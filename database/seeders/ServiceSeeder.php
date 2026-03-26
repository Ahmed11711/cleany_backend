<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        $servicesPool = [
            'Standard Kitchen Cleaning',
            'Full Bathroom Sanitization',
            'Living Room Deep Dusting',
            'Sofa Steam Cleaning',
            'External Window Wash',
            'Curtain Dry Cleaning',
            'Mattress Vacuuming'
        ];

        foreach ($companies as $company) {
            $randomServices = array_rand(array_flip($servicesPool), rand(3, 5));

            foreach ((array)$randomServices as $name) {
                $originalPrice = rand(150, 600);

                $discountPercentage = rand(0, 1) ? rand(5, 25) : 0;

                $priceToday = rand(0, 1) ? $originalPrice * (rand(70, 90) / 100) : null;

                Service::create([
                    'company_id'   => $company->id,
                    'service_name' => $name,
                    'price'        => $originalPrice,
                    'price_today'  => $priceToday,
                    'discount'     => $discountPercentage,
                ]);
            }
        }
    }
}
