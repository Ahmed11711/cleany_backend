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
        // 1. جلب كل معرفات المستخدمين (role = company) وتحويلها لمجموعة (Collection)
        // استخدمنا shuffle() لضمان توزيع عشوائي في كل مرة تشغل فيها الـ Seed
        $adminIds = User::where('role', 'company')->pluck('id')->shuffle();

        $companiesData = [
            [
                'name' => 'Elite Cleaners',
                'logo' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6954?q=80&w=400&auto=format&fit=crop',
                'address' => '90th St, New Cairo',
                'phone' => '01012345678',
                'description' => 'Professional home and office cleaning services.',
                'rating' => 4.5,
                'hourly_rate' => 100.00,
                'is_verified' => true,
                'free_delivery' => true,
            ],
            [
                'name' => 'Swift Wash',
                'logo' => 'https://images.unsplash.com/photo-1520340356584-f9917d1eea6f?q=80&w=400&auto=format&fit=crop',
                'address' => 'Maadi, Degla St',
                'phone' => '01198765432',
                'description' => 'Fast and reliable car wash and carpet cleaning.',
                'rating' => 4.2,
                'hourly_rate' => 80.00,
                'is_verified' => true,
                'free_delivery' => false,
            ],

        ];

        $categories = Category::all();
        $regions = Region::all();

        foreach ($companiesData as $index => $data) {

            // 2. سحب معرف مستخدم واحد من القائمة وحذفه منها لضمان عدم تكراره (shift)
            $adminId = $adminIds->shift();

            // تأكد إن فيه مستخدم متاح، لو خلصوا هيوقف عشان ميرميش Error
            if (!$adminId) {
                $this->command->warn("No more unique users with role 'company' available for company: {$data['name']}");
                continue;
            }

            $company = Company::create(array_merge($data, [
                'admin_id' => $adminId
            ]));

            // ربط الأقسام والمناطق
            if ($index < 2) {
                $company->categories()->attach(
                    $categories->random(min(2, $categories->count()))->pluck('id'),
                    ['region_id' => $regions->isNotEmpty() ? $regions->random()->id : null]
                );
            } else {
                $company->categories()->attach(
                    $categories->random(min(1, $categories->count()))->pluck('id'),
                    ['region_id' => null]
                );
            }
        }
    }
}
