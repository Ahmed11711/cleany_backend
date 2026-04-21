<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    public function driverServices(): HasMany
    {
        // لاحظ أننا نستخدم 'service_item_id' كـ Foreign Key بناءً على تعديل المايجريشن السابق
        return $this->hasMany(DriverService::class, 'service_item_id');
    }

    /**
     * علاقة عكسية مع الخدمة الرئيسية (إذا كنت تحتاجها)
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
