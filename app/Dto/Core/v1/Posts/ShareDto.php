<?php

namespace App\Dto\Core\v1\Posts;

use App\Http\Requests\Core\v1\Posts\ShareRequest;

readonly class ShareDto
{
    /**
     * Summary of __construct
     * @param int $postId
     */
    public function __construct(
        public int $postId,
    ) {
    }


    public static function from(ShareRequest $request): self
    {
        return new self(
            postId: $request->get('post_id'),
        );
    }
}
