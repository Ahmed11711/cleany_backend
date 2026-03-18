<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'      => 'Home Cleaning',
                'image'     => 'https://images.unsplash.com/photo-1581578731548-c64695ce6958?q=80&w=800', // صورة تنظيف منزل مودرن
                'is_active' => true,
            ],
            [
                'name'      => 'Carpet Cleaning',
                'image'     => 'https://images.unsplash.com/photo-1558317374-067fb5f30001?q=80&w=800', // صورة تنظيف سجاد عميق
                'is_active' => true,
            ],
            [
                'name'      => 'Deep Cleaning',
                'image'     => 'https://images.unsplash.com/photo-1527515545081-5db817172677?q=80&w=800', // صورة تفاصيل تنظيف مطبخ/حمام
                'is_active' => true,
            ],
            [
                'name'      => 'Office Cleaning',
                'image'     => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?q=80&w=800', // صورة مكاتب وشركات
                'is_active' => true,
            ],
            [
                'name'      => 'Car Wash',
                'image'     => 'https://images.unsplash.com/photo-1520340356584-f9917d1eea6f?q=80&w=800', // صورة غسيل سيارات احترافي
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
