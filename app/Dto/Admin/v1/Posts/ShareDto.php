<?php

namespace App\Dto\Admin\v1\Posts;

use App\Http\Requests\Admin\v1\Posts\ShareRequest;

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

    /**
     * Summary of from
     * @param \App\Http\Requests\Admin\v1\Posts\ShareRequest $request
     * @return ShareDto
     */
    public static function from(ShareRequest $request): self
    {
        return new self(
            postId: $request->get('post_id'),
        );
    }
}
