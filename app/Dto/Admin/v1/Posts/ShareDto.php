<?php

namespace App\Dto\Admin\v1\Posts;

use App\Http\Requests\Admin\v1\Posts\ShareRequest;

readonly class ShareDto
{
    public function __construct(
        public int $postId,
        public array $usersId,
    ) {
    }

    public static function from(ShareRequest $request): self
    {
        return new self(
            postId: $request->get('post_id'),
            usersId: $request->get('users_id'),
        );
    }
}
