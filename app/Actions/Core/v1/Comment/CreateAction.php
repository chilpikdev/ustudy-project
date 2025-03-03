<?php

namespace App\Actions\Core\v1\Comment;

use App\Dto\Core\v1\Comment\CreateDto;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;


class CreateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Core\v1\Comment\CreateDto $dto
     * @return JsonResponse
     */
    public function __invoke(CreateDto $dto): JsonResponse
    {
        $post = Post::find($dto->postId);

        $post->comments()->create([
            'content' => $dto->content,
            'user_id' => auth()->id(),
        ]);

        return static::toResponse(
            message: 'Comment created!'
        );
    }
}
