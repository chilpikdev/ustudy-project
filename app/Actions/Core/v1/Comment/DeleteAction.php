<?php

namespace App\Actions\Core\v1\Comment;

use App\Exceptions\ApiResponseException;
use App\Models\Comment;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;


class DeleteAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $comment = Comment::findOrFail($id);

            $comment->delete();

            return static::toResponse(
                message: 'Comment deleted!'
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Comment Not Found', 404);
        }

    }
}
