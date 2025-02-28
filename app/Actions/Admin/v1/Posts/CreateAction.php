<?php

namespace App\Actions\Admin\v1\Posts;

use App\Dto\Admin\v1\Posts\CreateDto;
use App\Exceptions\ApiResponseException;
use App\Helpers\FileUploadHelper;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class CreateAction
{
    use ResponseTrait;

    public function __invoke(CreateDto $dto): JsonResponse
    {

        DB::beginTransaction();

        try {
            $userId = auth()->id();
            $data = [
                'user_id' => $userId,
                'title' => $dto->title,
                'description' => $dto->description,
                'content' => $dto->content,
            ];

            if ($dto->recommended) {
                $data['recommended'] = $dto->recommended;
            }

            $item = Post::create($data);
            $uploadedFiles = FileUploadHelper::files($dto->files, "posts/{$item->id}");

            foreach ($uploadedFiles as $file) {
                $item->files()->create($file);
            }

            DB::commit();

            return static::toResponse(
                message: "Post created"
            );
        } catch (\Exception $e) {
            DB::rollBack();

            // foreach ($uploadedFiles as $filePath) {
            //     if (Storage::disk('public')->exists($filePath['path'])) {
            //         Storage::disk('public')->delete($filePath['path']);
            //     }
            // } delete helper and container user:group and permision

            throw new ApiResponseException('File jaratiwda qatelik', 500);
        }
    }
}
