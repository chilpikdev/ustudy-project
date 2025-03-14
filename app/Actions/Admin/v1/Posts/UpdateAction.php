<?php

namespace App\Actions\Admin\v1\Posts;

use App\Dto\Admin\v1\Posts\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Helpers\FileUploadHelper;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class UpdateAction
{
    use ResponseTrait;

    public function __invoke(UpdateDto $dto): JsonResponse
    {
        try {
            $item = Post::findOrFail($dto->id);

            $data = [
                'title' => $dto->title,
                'description' => $dto->description,
                'content' => $dto->content,
                'recommended' => $dto->recommended,
                'category_id' => $dto->categoryId,
                'slug' => Str::slug($dto->title),
            ];

            $item->update($data);

            $item->tags()->sync($dto->tags);
            if ($dto->files) {
                $uploadedFiles = FileUploadHelper::files($dto->files, "posts/{$item->id}");

                array_map(function ($file) use ($item) {
                    $item->files()->create($file);
                }, $uploadedFiles);
            }

            return static::toResponse(
                message: "Post updated"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Post not found", 404);
        }
    }
}
