<?php

namespace App\Actions\Admin\v1\Posts;

use App\Dto\Admin\v1\Posts\CreateDto;
use App\Helpers\FileUploadHelper;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    public function __invoke(CreateDto $dto): JsonResponse
    {
        $data = [
            'user_id' => auth()->id(),
            'category_id' => $dto->categoryId,
            'title' => $dto->title,
            'description' => $dto->description,
            'content' => $dto->content,
        ];

        if ($dto->recommended) {
            $data['recommended'] = $dto->recommended;
        }

        $item = Post::create($data);
        $uploadedFiles = FileUploadHelper::files($dto->files, "posts/{$item->id}");

        array_map(function ($file) use ($item) {
            $item->files()->create($file);
        }, $uploadedFiles);

        if($dto->tags){
            $item->tags()->attach(
                $dto->tags
            );
        }

        return static::toResponse(
            message: "Post created"
        );
    }
}
