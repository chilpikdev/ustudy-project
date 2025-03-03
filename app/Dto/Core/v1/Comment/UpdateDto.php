<?php

namespace App\Dto\Core\v1\Comment;

use App\Http\Requests\Core\v1\Comment\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public string $content,
        public int $commentId,
    ) {
    }

    public static function from(UpdateRequest $request): self
    {
        return new self(
            content: $request->get('content'),
            commentId: $request->get('comment_id'),
        );
    }
}
