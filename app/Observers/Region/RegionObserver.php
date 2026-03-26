<?php

namespace App\Observers\Region;

use App\Models\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class RegionObserver
{
    public function saved(Region $region): void
    {
        $this->clearRegionCache($region);
    }

    /**
     */
    public function deleted(Region $region): void
    {
        $this->clearRegionCache($region);
    }

    /**
     */
    public function restored(Region $region): void
    {
        $this->clearRegionCache($region);
    }

    /**
     */
    protected function clearRegionCache(Region $region): void
    {
        $tableName = $region->getTable();

        // 1. مسح كاش السجل الفردي الخاص بهذا القسم (Show)
        Cache::forget($tableName . '_show_' . $region->id);

        // 2. مسح كاش القوائم (Index)
        // بما أننا نستخدم MD5 Hash للمفاتيح، فالحل الأضمن هو flush
        // لضمان أن أي تغيير في اسم القسم أو صورته يظهر فوراً في كل القوائم
        Cache::flush();

        /* ملاحظة: لو حولت لـ Redis لاحقاً، الكود هيكون كدة:
         Cache::tags([$tableName])->flush();
         وده هيمسح كل كاش الأقسام فقط بدون لمس باقي الموقع.
        */
    }
}
