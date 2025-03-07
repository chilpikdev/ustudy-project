<?php

namespace App\Actions\Admin\v1\Category;

use App\Dto\Admin\v1\Category\UpdateDto;
use App\Exceptions\ApiResponseException;
use App\Models\Category;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    public function __invoke(UpdateDto $dto): JsonResponse
    {
        try {
            $item = Category::findOrFail($dto->id);

            $item->update([
                'name' => $dto->name,
            ]);

            return static::toResponse(
                message: "Category updated"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Category not found", 404);
        }
    }
}
