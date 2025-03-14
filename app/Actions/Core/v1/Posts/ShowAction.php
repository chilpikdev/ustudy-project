<?php

namespace App\Actions\Core\v1\Posts;

use App\Actions\Traits\CacheTrait;
use App\Exceptions\ApiResponseException;
use App\Http\Resources\Core\v1\Posts\ShowResource;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class ShowAction
{
    use ResponseTrait, CacheTrait;

    public function __invoke(int $id): JsonResponse
    {
        try {
            $identifier = auth('sanctum')->check() ? "user_" . auth('sanctum')->id() : "ip_" . request()->ip(); //if user is exist, get user_id. If not exist, get ip

            $cacheKey = "posts:show:{$id}:{$identifier}";

            $data = $this->remember($cacheKey, function () use ($id, $cacheKey) {
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
