<?php

namespace App\Actions\Core\v1\Posts;

use App\Actions\Traits\GenerateKeyCacheTrait;
use App\Exceptions\ApiResponseException;
use App\Http\Resources\Core\v1\Posts\ShowResource;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\PersonalAccessToken;

class ShowAction
{
    use GenerateKeyCacheTrait, ResponseTrait;

    public function __invoke(int $id, Request $request): JsonResponse
    {
        try {
            $cacheKey = 'posts:show' . $this->generateKey();
            $data = Cache::remember($cacheKey, now()->addDay(), function () use ($id) {
                return Post::findOrFail($id);
            });

            //Get token
            $token = PersonalAccessToken::findToken($request->bearerToken());

            if ($token) {
                $userId = $token->tokenable_id; //Get User Id with token

                $cacheViewKey = "post:view_{$userId}_{$id}";

                if (!Cache::has($cacheViewKey)) {
                    Cache::put($cacheViewKey, true, now()->addDay());

                    Post::where('id', $id)->increment('view'); // Updated Post view

                    $data = Post::findOrFail($id);
                    Cache::put($cacheKey, $data, now()->addDay());// Updated Post Cache
                }
            }

            return static::toResponse(
                data: new ShowResource($data),
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('post not found', 404);
        }
    }
}
