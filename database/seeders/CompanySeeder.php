<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Category;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // الحصول على الأدمن
        $adminId = User::where('role', 'super_admin')->first()?->id ?? 1;

        $companies = [
            [
                'name' => 'Elite Cleaners',
                // صورة تعبر عن خدمات تنظيف احترافية
                'logo' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6954?q=80&w=400&auto=format&fit=crop',
                'address' => '90th St, New Cairo',
                'phone' => '01012345678',
                'description' => 'Professional home and office cleaning services using eco-friendly products.',
                'rating' => 4.5,
                'hourly_rate' => 100.00,
                'is_verified' => true,
                'free_delivery' => true,
            ],
            [
                'name' => 'Swift Wash',
                // صورة تعبر عن خدمات غسيل السيارات أو السجاد
                'logo' => 'https://images.unsplash.com/photo-1520340356584-f9917d1eea6f?q=80&w=400&auto=format&fit=crop',
                'address' => 'Maadi, Degla St',
                'phone' => '01198765432',
                'description' => 'Fast and reliable car wash and carpet cleaning at your doorstep.',
                'rating' => 4.2,
                'hourly_rate' => 80.00,
                'is_verified' => true,
                'free_delivery' => false,
            ],
            [
                'name' => 'Global Services',
                // صورة تعبر عن شركة خدمات عامة أو صيانة
                'logo' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?q=80&w=400&auto=format&fit=crop',
                'address' => 'Remote / Global',
                'phone' => '01200000000',
                'description' => 'Comprehensive maintenance and facility management available everywhere.',
                'rating' => 4.8,
                'hourly_rate' => 150.00,
                'is_verified' => true,
                'free_delivery' => true,
            ],
        ];

        $categories = Category::all();
        $regions = Region::all();

        foreach ($companies as $index => $data) {
            $company = Company::create(array_merge($data, ['admin_id' => $adminId]));

            if ($index < 2) {
                // ربط بالخدمات والمناطق بشكل عشوائي للشركات المحلية
                $company->categories()->attach(
                    $categories->random(min(2, $categories->count()))->pluck('id'),
                    ['region_id' => $regions->isNotEmpty() ? $regions->random()->id : null]
                );
            } else {
                // للشركة العالمية
                $company->categories()->attach(
                    $categories->random(min(1, $categories->count()))->pluck('id'),
                    ['region_id' => null]
                );
            }
        }
    }
}
