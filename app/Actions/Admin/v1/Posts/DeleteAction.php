<?php

namespace App\Actions\Admin\v1\Posts;

use App\Exceptions\ApiResponseException;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteAction
{
    use ResponseTrait;

    public function __invoke(int $id): JsonResponse
    {
        try {
            $item = Post::findOrFail($id);
            $item->delete();

            return static::toResponse(
                message: "Post deleted"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Post not found", 404);
        }
    }
}
