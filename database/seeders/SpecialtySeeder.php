<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    public function run(): void
    {
        // هنجيب كل الشركات اللي في السيستم
        $companies = Company::all();

        // قائمة تخصصات مقترحة (احترافية)
        $specialtiesPool = [
            'Eco-friendly Products',
            'Post-Construction Cleaning',
            'Steam Sanitization',
            'Furniture Polishing',
            'Disinfection Services',
            'Allergy-friendly Cleaning',
            'Industrial Grade Equipment',
            'Pet Stain Removal'
        ];

        foreach ($companies as $company) {
            // كل شركة هنديها من 2 لـ 4 تخصصات عشوائية
            $randomSpecialties = array_rand(array_flip($specialtiesPool), rand(2, 4));

            foreach ((array)$randomSpecialties as $name) {
                Specialty::create([
                    'name'       => $name,
                    'company_id' => $company->id,
                    'is_active'  => true,
                ]);
            }
        }
    }
}
