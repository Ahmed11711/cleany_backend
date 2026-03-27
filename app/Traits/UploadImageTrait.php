<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UploadImageTrait
{
    /**
     * @param Request $request
     * @param array $data (The validated data)
     * @param string $folder (Sub-folder name like 'Company' or 'User')
     * @param array $fileFields (Fields to check in request like ['logo', 'cover'])
     * @param mixed $existingRecord (Optional: for deleting old files during update)
     * @return array
     */
    // protected function uploadManager(Request $request, array $data, string $folder, array $fileFields, $existingRecord = null)
    // {
    //     foreach ($fileFields as $field) {
    //         if ($request->hasFile($field)) {

    //             if ($existingRecord && !empty($existingRecord->$field)) {
    //                 $oldPath = str_replace(config('app.url') . "/storage/", "", $existingRecord->$field);
    //                 Storage::disk('public')->delete($oldPath);
    //             }

    //             $file = $request->file($field);
    //             $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName()); // تنظيف اسم الملف
    //             $path = $file->storeAs("uploads/{$folder}", $filename, 'public');

    //             $data[$field] = config('app.url') . "/storage/" . $path;
    //         }
    //     }
    //     return $data[$field];
    // }
    protected function uploadManager(Request $request, array $data, string $folder, array $fileFields, $existingRecord = null)
    {
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // 1. حذف القديم من مجلد media
                if ($existingRecord && !empty($existingRecord->$field)) {
                    // استخراج المسار بعد كلمة /media/
                    $oldRelativePath = last(explode('/media/', $existingRecord->$field));
                    $fullOldPath = public_path('media/' . $oldRelativePath);
                    if (file_exists($fullOldPath)) {
                        unlink($fullOldPath);
                    }
                }

                // 2. الرفع المباشر لمجلد public/media
                $file = $request->file($field);
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $destinationPath = public_path("media/uploads/{$folder}");

                // التأكد من وجود المجلد أو إنشاؤه
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }

                $file->move($destinationPath, $filename);

                // 3. الرابط الصحيح للمتصفح (بدون كلمة storage)
                $data[$field] = rtrim(config('app.url'), '/') . "/media/uploads/{$folder}/" . $filename;
            }
        }
        return $data[$field] ?? ($existingRecord ? $existingRecord->$field : null);
    }
}
