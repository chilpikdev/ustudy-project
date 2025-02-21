<?php

namespace App\Actions\Admin\v1\Posts;

use App\Dto\Admin\v1\Posts\CreateDto;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'title' => $dto->title,
            'description' => $dto->description,
            'content' => $dto->content,
        ];

        if ($dto->recommended) {
            $data['recommended'] = $dto->recommended;
        }

        Post::create($data);

        return static::toResponse(
            message: "Post created"
        );
    }
}
