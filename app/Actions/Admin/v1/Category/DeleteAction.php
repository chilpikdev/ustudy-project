<?php

namespace App\Actions\Admin\v1\Category;

use App\Exceptions\ApiResponseException;
use App\Models\Category;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteAction
{
    use ResponseTrait;

    public function __invoke(int $id): JsonResponse
    {
        try {

            $data = Category::findOrFail($id);
            $data->delete();

            return static::toResponse(
                message: "Category deleted"
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException("Category not found", 404);
        }
    }
}
