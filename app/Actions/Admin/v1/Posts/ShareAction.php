<?php

namespace App\Actions\Admin\v1\Posts;

use App\Dto\Admin\v1\Posts\ShareDto;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ShareAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Admin\v1\Posts\ShareDto $dto
     * @return JsonResponse
     */
    public function __invoke(ShareDto $dto): JsonResponse
    {
        $post = Post::find($dto->postId);
        $post->increment('shared');

        return static::toResponse(
            message: "Post shared"
        );
    }
}
