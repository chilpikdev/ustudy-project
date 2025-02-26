<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileDeleteHelper
{
    /**
     * Summary of file
     * @param string $path
     * @return void
     */
    public static function file(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Summary of files
     * @param array $files
     * @param string $path
     * @return void
     */
    public static function files(array $files, string $path): void
    {
        foreach ($files as $file) {
            self::file($file);
        }

        Storage::disk('public')->deleteDirectory($path);
    }
}
