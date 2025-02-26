<?php

namespace App\Actions\Admin\v1\File;

use App\Exceptions\ApiResponseException;
use App\Helpers\FileDeleteHelper;
use App\Models\File;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteAction
{
    use ResponseTrait;

    public function __invoke(string $id): JsonResponse
    {
        try {
            $file = File::findOrFail($id);
            FileDeleteHelper::file($file->path);
            $file->delete();

            return static::toResponse(
                message: 'File deleted'
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('File not found', 404);
        }
    }
}
