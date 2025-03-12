<?php

namespace App\Actions\Admin\v1\Posts;

use App\Dto\Admin\v1\Posts\ShareDto;
use App\Models\Post;
use App\Traits\ResponseTrait;

class ShareAction
{
    use ResponseTrait;

    public function __invoke(ShareDto $dto)
    {
        $post = Post::find($dto->postId);
        $usersId = array_unique($dto->usersId);
        $count = count($usersId);
        $post->shared = $post->shared + $count;
        $post->update();

        return static::toResponse(
            message: "Post shared to $count users"
        );
    }
}
