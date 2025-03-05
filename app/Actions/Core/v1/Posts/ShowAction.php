<?php

namespace App\Actions\Core\v1\Posts;

use App\Actions\Traits\GenerateKeyCacheTrait;
use App\Exceptions\ApiResponseException;
use App\Http\Resources\Core\v1\Posts\ShowResource;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ShowAction
{
    use GenerateKeyCacheTrait, ResponseTrait;

    public function __invoke(int $id): JsonResponse
    {
        try {
            $identifier = auth('sanctum')->check() ? "user_" . auth('sanctum')->id() : "ip_" . request()->ip(); //if user is exist, get user_id. If not exist, get ip 

            $cacheKey = "posts:show:{$id}:{$identifier}";

            $data = Cache::remember($cacheKey . ':' . app()->getLocale(), now()->addDay(), function () use ($id, $cacheKey) {
                $data = Post::findOrFail($id);

                if (!Redis::keys("*$cacheKey*")) {
                    $data->increment('view');
                }

                return $data;
            });

            return static::toResponse(
                data: new ShowResource($data),
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('post not found', 404);
        }
    }
}
