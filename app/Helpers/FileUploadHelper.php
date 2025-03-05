<?php

namespace App\Helpers;

use App\Exceptions\ApiResponseException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadHelper
{
    /**
     * Summary of files
     * @param array $files
     * @param mixed $path
     * @throws \App\Exceptions\ApiResponseException
     * @return array
     */
    public static function files(array $files, $path): array
    {
        $uploadedFiles = [];

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) {
                throw new ApiResponseException("Ju'klengen fayl tipi duris emes", 400);
            }

            $uploadedFiles[] = self::file($file, $path);
        }

        return array_filter($uploadedFiles);
    }

    /**
     * Summary of file
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path
     * @return array|array{extension: string, name: string, path: bool|string, size: bool|int}
     */
    public static function file(UploadedFile $file, string $path): array
    {
        $fileName = Str::random() . '-' . now()->format('Y-m-d-H:i:s') . '.' . $file->extension();
        $savedPath = Storage::disk('public')->putFileAs($path, $file, $fileName);

        return $savedPath ? [
            'path' => $savedPath,
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'extension' => $file->extension(),
        ] : [];
    }
}
