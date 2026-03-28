<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء المدير العام (Super Admin)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@cleany.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // 2. إنشاء حساب شركة (Company)
        // لنفترض إن عندك شركة في جدول الشركات بـ ID = 1
        User::create([
            'name' => 'CleanCo Services',
            'email' => 'info@cleanco.com',
            'password' => Hash::make('password'),
            'role' => 'company',
            'company_id' => 1, // تأكد إن الـ ID ده موجود في جدول الشركات
            'is_active' => true,
        ]);

        // 3. إنشاء موظف (Staff) تابع للشركة رقم 1
        User::create([
            'name' => 'Ahmed Staff',
            'email' => 'ahmed@cleanco.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'company_id' => 1,
            'is_active' => true,
        ]);

        // 4. إنشاء مستخدم عادي (Client/User)
        User::create([
            'name' => 'Mostafa User',
            'email' => 'mostafa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'company',
            'is_active' => true,
        ]);
    }
}
