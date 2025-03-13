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

    /**
     * Summary of __invoke
     * @param int $id
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $identifier = auth('sanctum')->check() ? "user_" . auth('sanctum')->id() : "ip_" . request()->ip();

            $cacheKey = "posts_show:{$id}:{$identifier}";

            $data = Cache::remember($cacheKey . $this->generateKey(), now()->addDay(), function () use ($id) {
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
