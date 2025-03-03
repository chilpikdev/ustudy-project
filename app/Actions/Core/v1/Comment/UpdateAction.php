<?php

namespace App\Actions\Core\v1\Comment;

use App\Dto\Core\v1\Comment\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Comment;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Core\v1\Comment\UpdateDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(UpdateDto $dto): JsonResponse
    {
        $comment = Comment::find($dto->commentId);

        if ($comment->user_id !== auth()->id()) {
            throw new ApiResponseException(message: 'Unauthorized', code: 403);
        }

        $comment->update([
            'content' => $dto->content
        ]);

        return static::toResponse(
            message: 'Comment updated!'
        );
    }
}
