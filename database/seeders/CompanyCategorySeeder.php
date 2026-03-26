<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Database\Seeder;

class CompanyCategorySeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        $categories = Category::all();
        $regions = Region::all();

        foreach ($companies as $company) {
            $randomCategories = $categories->random(rand(2, 3));

            foreach ($randomCategories as $category) {
                // نصيحة خبير: هنخلي فيه تنوع (منطقة محددة أو جلوبال)
                $useRegion = rand(0, 1); // 50% احتمال تكون في منطقة

                $company->categories()->attach($category->id, [
                    'region_id'   => $useRegion ? $regions->random()->id : null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }
}
