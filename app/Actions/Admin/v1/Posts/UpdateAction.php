<?php

namespace App\Actions\Admin\v1\Posts;

use App\Dto\Admin\v1\Posts\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

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
            ];

            $item->update($data);

            return static::toResponse(
                message: "Post updated"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Post not found", 404);
        }
    }
}
