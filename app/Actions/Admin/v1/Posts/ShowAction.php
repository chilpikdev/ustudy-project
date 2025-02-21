<?php

namespace App\Actions\Admin\v1\Posts;

use App\Actions\Traits\GenerateKeyCacheTrait;
use App\Exceptions\ApiResponseException;
use App\Http\Resources\Admin\v1\Posts\ShowResource;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ShowAction
{
    use GenerateKeyCacheTrait, ResponseTrait;

    public function __invoke(int $id): JsonResponse
    {
        try {
            $data = Cache::remember('posts:show' . $this->generateKey(), now()->addDay(), function () use ($id) {
                return Post::findOrFail($id);
            });

            return static::toResponse(
                data: new ShowResource($data),
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('post not found', 404);
        }
    }
}
