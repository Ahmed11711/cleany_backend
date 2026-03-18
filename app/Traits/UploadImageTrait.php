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
    protected function uploadManager(Request $request, array $data, string $folder, array $fileFields, $existingRecord = null)
    {
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {

                if ($existingRecord && !empty($existingRecord->$field)) {
                    $oldPath = str_replace(config('app.url') . "/storage/", "", $existingRecord->$field);
                    Storage::disk('public')->delete($oldPath);
                }

                $file = $request->file($field);
                $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName()); // تنظيف اسم الملف
                $path = $file->storeAs("uploads/{$folder}", $filename, 'public');

                $data[$field] = config('app.url') . "/storage/" . $path;
            }
        }
        return $data[$field];
    }
}
