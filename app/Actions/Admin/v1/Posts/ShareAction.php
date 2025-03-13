<?php

namespace App\Actions\Admin\v1\Posts;

use App\Dto\Admin\v1\Posts\ShareDto;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ShareAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Admin\v1\Posts\ShareDto $dto
     * @return JsonResponse
     */
    public function __invoke(ShareDto $dto): JsonResponse
    {
        $post = Post::find($dto->postId);
        $usersId = array_unique($dto->usersId);
        $count = count($usersId);
        $post->shared = $post->shared + $count;
        $post->update();

        $keys = Redis::keys('*posts*');

        if(count($keys) != 0){
            foreach ($keys as $key) {
                $key = substr($key, 25); // prefixti qirqip aliw ushin

                if (str_starts_with($key, 'posts_show')) {
                    $start = strpos($key, ':') + 1;
                    $end = strpos($key, ':', $start);

                    $result = substr($key, $start, $end - $start); // post id di qirqip aliw

                    if($post->id == $result){
                        Cache::forget($key);
                    }
                } else {
                    Cache::forget($key);
                }
            }
        }

        return static::toResponse(
            message: "Post shared to $count users"
        );
    }
}
