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

        // قائمة خدمات واقعية لمجال التنظيف
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
            // كل شركة هنديها من 3 لـ 5 خدمات عشوائية من القائمة
            $randomServices = array_rand(array_flip($servicesPool), rand(3, 5));

            foreach ((array)$randomServices as $name) {
                $originalPrice = rand(100, 500);
                // السعر النهاردة هيكون خصم 10% لـ 30% من السعر الأصلي (اختياري)
                $discount = rand(0, 1) ? $originalPrice * (rand(70, 90) / 100) : null;

                Service::create([
                    'company_id'   => $company->id,
                    'service_name' => $name,
                    'price'        => $originalPrice,
                    'price_today'  => $discount,
                ]);
            }
        }
    }
}
