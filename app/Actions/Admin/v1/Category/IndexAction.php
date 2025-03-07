<?php

namespace App\Actions\Admin\v1\Category;

use App\Actions\Traits\GenerateKeyCacheTrait;
use App\Http\Resources\Core\v1\Category\CategoryResource;
use App\Models\Category;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use GenerateKeyCacheTrait, ResponseTrait;

    public function __invoke(): JsonResponse
    {
        $data = Cache::remember('categories' . $this->generateKey(), now()->addDay(), function ()  {
            return Category::all();
        });

        return static::toResponse(
            message: "Successfully received",
            data: CategoryResource::collection($data),
        );
    }
}
