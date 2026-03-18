<?php

namespace App\Services\command;

use Illuminate\Support\Facades\File;

class ObserverRegistrationService
{
    public static function register(string $model, string $observerClass)
    {
        $path = app_path('Providers/AppServiceProvider.php');
        $content = File::get($path);

        $modelClass = "App\\Models\\{$model}";
        $registrationLine = "\\{$modelClass}::observe(\\{$observerClass}::class);";

        if (str_contains($content, $registrationLine)) {
            return;
        }

        $content = preg_replace(
            '/(public function boot\(\): void\s*\{)/',
            "$1\n        {$registrationLine}",
            $content
        );

        File::put($path, $content);
    }
}
