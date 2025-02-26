<?php

namespace App\Actions\Admin\v1\File;

use App\Exceptions\ApiResponseException;
use App\Models\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadAction
{
    public function __invoke(string $id): BinaryFileResponse
    {
        try {
            $file = File::findOrFail($id);

            return response()->download(
                file: Storage::disk('public')->path($file->path),
                name: $file->name,
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('File not found', 404);
        }
    }
}
