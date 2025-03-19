<?php

namespace App\Actions\Core\v1\Posts;

use App\Dto\Core\v1\Posts\ShareDto;
use App\Exceptions\ApiResponseException;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ShareAction
{
    use ResponseTrait;


    /**
     * Summary of __invoke
     * @param \App\Dto\Core\v1\Posts\ShareDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(ShareDto $dto): JsonResponse
    {
        try {
            $post = Post::findOrFail($dto->postId);
            $post->increment('shared');

            return static::toResponse(
                message: "Post shared"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Post not found", 404);
        }
    }
}
