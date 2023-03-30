<?php

namespace Modules\Api\Http\Services;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    /**
     * @param File $file
     * @param string $directory
     * @param string|null $exists
     * @return mixed
     */
    public static function storeOrUpdateFile($file, $directory, $exists = null)
    {
        if (!$file->isFile()) {
            return null;
        }

        if ($exists) {
            if (Str::contains($exists, 'storage/')) {
                $exists = Str::replace('storage/', '', $exists);
            }

            if (Storage::exists($exists)) {
                Storage::delete($exists);
            }
        }

        return "storage/" . $file->store($directory);
    }
}
