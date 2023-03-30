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
            self::deleteFile(self::trimStorage($exists));
        }

        return "storage/" . $file->store($directory);
    }

    /**
     * @param $path
     * @return mixed|string
     */
    public static function trimStorage($path)
    {
        if (Str::contains($path, 'storage/')) {
            $path = Str::replace('storage/', '', $path);
        }

        return $path;
    }

    /**
     * @param $path
     * @return bool
     */
    public static function deleteFile($path): bool
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        return false;
    }
}
