<?php

namespace App\Dto\Core\v1\Comment;

use App\Http\Requests\Core\v1\Comment\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public string $content,
        public int $postId,
    ) {
    }

    public static function from(CreateRequest $request): self
    {
        return new self(
            content: $request->get('content'),
            postId: $request->get('post_id'),
        );
    }
}
