<?php

namespace App\Services\Tracking;

use Illuminate\Support\Facades\Redis;

class TrackingService
{
    public function updateSingleStaff(int $userId, array $coords)
    {
        $key = "active_tracking:{$userId}";

        // تخزين الإحداثيات في Hash سريع
        Redis::hmset($key, [
            'lat' => $coords['lat'],
            'lng' => $coords['lng'],
            'last_ping' => now()->timestamp, // نستخدم Timestamp لسهولة الحساب
            'status' => 'moving'
        ]);

        // "سحر الريديس": نخلي البيانات تمسح نفسها لو الموظف مبعتش تحديث خلال 5 دقائق
        // ده بيضمن إنك متراقبش حد "ناسي" الأبلكيشن مفتوح
        Redis::expire($key, 300);
    }

    // دالة لجلب بيانات موظف واحد فقط للخريطة
    public function getStaffLocation(int $userId)
    {
        return Redis::hgetall("active_tracking:{$userId}");
    }
}
