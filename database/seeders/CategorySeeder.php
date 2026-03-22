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
                // صورة 3D لغرفة معيشة نظيفة ومرتبة
                'image'     => 'https://avatars.mds.yandex.net/i?id=d117b0e72aa92ab6ea7465e5b9acd3027718a4d6-16329014-images-thumbs&n=13',
                'is_active' => true,
            ],
            [
                'name'      => 'Carpet Cleaning',
                // صورة 3D قريبة تركز على قوام السجاد النظيف
                'image'     => 'https://avatars.mds.yandex.net/i?id=64ee8b7753fb81c41d0984b075c5fb3558eb022f-3557397-images-thumbs&n=13',
                'is_active' => true,
            ],
            [
                'name'      => 'Deep Cleaning',
                // صورة 3D لمطبخ حديث أو تفاصيل نظافة دقيقة
                'image'     => 'https://t4.ftcdn.net/jpg/09/51/03/29/360_F_951032937_xXH2zMhXdIV7Mta5H91lSyjhasENKLUa.jpg',
                'is_active' => true,
            ],
            [
                'name'      => 'Office Cleaning',
                // صورة 3D لمكتب عمل عصري أو مساحة عمل مفتوحة
                'image'     => 'https://avatars.mds.yandex.net/i?id=9573f0fe88fc75415b58840c7cea1033adf235f0-10896002-images-thumbs&n=13',
                'is_active' => true,
            ],
            [
                'name'      => 'Car Wash',
                // صورة 3D لسيارة لامعة ونظيفة تمامًا
                'image'     => 'https://avatars.mds.yandex.net/i?id=c7511dad5773917e996cc93d6c96fde4b6571276-5088393-images-thumbs&n=13',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
