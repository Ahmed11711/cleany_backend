<?php

namespace App\Services\command;

use Illuminate\Support\Facades\File;

class ObserverGenerator
{
    /**
     * إنشاء ملف Observer مخصص للموديل
     *
     * @param string $model اسم الموديل (مثل User)
     * @param string|null $module اسم الموديول في حالة HMVC
     * @return string الـ Namespace الكامل للـ Observer الناتج
     */
    public static function make(string $model, ?string $module = null): string
    {
        // 1. تحديد المسار والـ Namespace بناءً على وجود موديول أو لا
        if ($module) {
            $basePath = base_path("Modules/{$module}/app/Observers/{$model}");
            $namespace = "Modules\\{$module}\\Observers\\{$model}";
        } else {
            $basePath = app_path("Observers/{$model}");
            $namespace = "App\\Observers\\{$model}";
        }

        $filePath = "{$basePath}/{$model}Observer.php";

        // 2. التأكد من وجود المجلد، وإذا لم يوجد يتم إنشاؤه
        if (!File::isDirectory($basePath)) {
            File::makeDirectory($basePath, 0755, true);
        }

        // 3. كتابة القالب (Template) مع استبدال المتغيرات
        $template = "<?php

namespace {$namespace};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class {$model}Observer
{
    /**
      */
    public function saved(Model \$model): void
    {
        \$this->clearCache(\$model);
    }

    /**
      */
    public function deleted(Model \$model): void
    {
        \$this->clearCache(\$model);
    }

    /**
      */
    public function restored(Model \$model): void
    {
        \$this->clearCache(\$model);
    }

    /**
      */
    protected function clearCache(Model \$model): void
    {
        \$tableName = \$model->getTable();
        
         Cache::forget(\$tableName . '_show_' . \$model->id);

         Cache::flush();

        /**
         
          * Cache::tags([\$tableName])->flush();
         */
    }
}
";

        // 4. حفظ الملف الفعلي
        File::put($filePath, $template);
        // إرجاع الـ Namespace لاستخدامه في عملية الـ Registration
        return "{$namespace}\\{$model}Observer";
    }
}
