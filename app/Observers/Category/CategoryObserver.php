<?php

namespace App\Observers\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{

    public function saved(Category $category): void
    {
        $this->clearCategoryCache($category);
    }

    /**
     * تنظيف الكاش عند الحذف
     */
    public function deleted(Category $category): void
    {
        $this->clearCategoryCache($category);
    }

    /**
     * تنظيف الكاش عند الاستعادة
     */
    public function restored(Category $category): void
    {
        $this->clearCategoryCache($category);
    }

    /**
     * منطق مسح الكاش المشترك ليتوافق مع الـ BaseController
     */
    protected function clearCategoryCache(Category $category): void
    {
        $tableName = $category->getTable();

        // 1. مسح كاش السجل الفردي الخاص بهذا القسم (Show)
        Cache::forget($tableName . '_show_' . $category->id);

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
