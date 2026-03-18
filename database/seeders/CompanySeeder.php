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
        // هنجيب الـ Admin اللي عملناه في الـ UserSeeder عشان نربط بيه الشركات
        $adminId = User::where('role', 'super_admin')->first()?->id ?? 1;

        // بيانات شركات وهمية بس شكلها حقيقي
        $companies = [
            [
                'name' => 'Elite Cleaners',
                'logo' => 'https://logo.clearbit.com/clean.com',
                'address' => '90th St, New Cairo',
                'phone' => '01012345678',
                'description' => 'Professional home and office cleaning services.',
                'rating' => 4.5,
                'hourly_rate' => 100.00,
                'is_verified' => true,
            ],
            [
                'name' => 'Swift Wash',
                'logo' => 'https://logo.clearbit.com/wash.io',
                'address' => 'Maadi, Degla St',
                'phone' => '01198765432',
                'description' => 'Fast and reliable car wash and carpet cleaning.',
                'rating' => 4.2,
                'hourly_rate' => 80.00,
                'is_verified' => true,
            ],
            [
                'name' => 'Global Services',
                'logo' => 'https://logo.clearbit.com/global.com',
                'address' => 'Remote / Global',
                'phone' => '01200000000',
                'description' => 'Available everywhere with no specific region.',
                'rating' => 4.8,
                'hourly_rate' => 150.00,
                'is_verified' => true,
            ],
        ];

        $categories = Category::all();
        $regions = Region::all();

        foreach ($companies as $index => $data) {
            $company = Company::create(array_merge($data, ['admin_id' => $adminId]));

            if ($index < 2) {
                $company->categories()->attach(
                    $categories->random(2)->pluck('id'), // قسمين عشوائيين
                    [
                        'region_id' => $regions->random()->id, // منطقة عشوائية
                    ]
                );
            } else {
                $company->categories()->attach(
                    $categories->random(1)->pluck('id'),
                    [
                        'region_id' => null,
                    ]
                );
            }
        }
    }
}
