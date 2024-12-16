<?php

namespace App\Actions\Core\v1\Posts;

use App\Dto\Core\v1\Posts\IndexDto;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class IndexAction
{
    use ResponseTrait;

    public function __invoke(IndexDto $dto): JsonResponse
    {
        $data = Cache::remember('posts', now()->addDay(), function () {
            $items = Post::query();
            return $items->paginate(perPage: 10, page: 1);
        });

        return static::toResponse(
            data: [
                'count' => count($data),
                'ttl' => Redis::ttl(config('cache.prefix') . 'posts'),
                'items' => $data->items()
            ]
        );
    }
}
