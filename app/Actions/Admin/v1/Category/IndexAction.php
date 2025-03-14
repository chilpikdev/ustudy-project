<?php

namespace App\Actions\Admin\v1\Category;

use App\Actions\Traits\CacheTrait;
use App\Http\Resources\Core\v1\Category\CategoryResource;
use App\Models\Category;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class IndexAction
{
    use ResponseTrait, CacheTrait;

    public function __invoke(): JsonResponse
    {
        $data = $this->remember( 'categories', function ()  {
            return Category::all();
        });

        return static::toResponse(
            message: "Successfully received",
            data: CategoryResource::collection($data),
        );
    }
}
