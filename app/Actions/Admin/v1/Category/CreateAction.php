<?php

namespace App\Actions\Admin\v1\Category;

use App\Dto\Admin\v1\Category\CreateDto;
use App\Models\Category;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    public function __invoke(CreateDto $dto): JsonResponse
    {
        Category::create([
            'name' => $dto->name,
        ]);

        return static::toResponse(
            message: "Category created"
        );
    }
}
