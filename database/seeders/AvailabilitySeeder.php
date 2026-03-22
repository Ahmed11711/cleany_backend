<?php

namespace Database\Seeders;

use App\Models\Availability;
use App\Models\Company;
use App\Models\Service;
use Illuminate\Database\Seeder;

class AvailabilitySeeder extends Seeder
{
    public function run(): void
    {
        // هنجيب أول شركة وأول خدمتين عشان نربط بيهم المواعيد
        $company = Company::first();
        $services = Service::where('company_id', $company->id)->get();

        if ($services->count() < 2) {
            $this->command->error('Please seed services first!');
            return;
        }

        $availabilities = [
            // خدمة رقم 1: Home Cleaning (متاحة السبت والأحد شفت صباحي)
            [
                'company_id' => $company->id,
                'service_id' => $services[0]->id,
                'day_of_week' => 6, // السبت
                'start_time' => '08:00:00',
                'end_time'   => '12:00:00',
            ],
            [
                'company_id' => $company->id,
                'service_id' => $services[0]->id,
                'day_of_week' => 0, // الأحد
                'start_time' => '08:00:00',
                'end_time'   => '12:00:00',
            ],

            // خدمة رقم 2: Car Wash (متاحة شفتات مسائية طول الأسبوع)
            [
                'company_id' => $company->id,
                'service_id' => $services[1]->id,
                'day_of_week' => 1, // الاثنين
                'start_time' => '16:00:00',
                'end_time'   => '20:00:00',
            ],
            [
                'company_id' => $company->id,
                'service_id' => $services[1]->id,
                'day_of_week' => 2, // الثلاثاء
                'start_time' => '18:00:00',
                'end_time'   => '22:00:00',
            ],
        ];

        foreach ($availabilities as $data) {
            Availability::create($data);
        }
    }
}
