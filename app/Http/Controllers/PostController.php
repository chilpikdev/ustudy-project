<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    public function posts(): JsonResponse
    {
        $data = Cache::remember('posts', now()->addMinute(), function () {
            $items = Post::query();
            return $items->paginate(perPage: 10, page: 1);
        });

        return response()->json([
            'count' => count($data),
            'ttl' => Redis::ttl(config('cache.prefix') . 'posts'),
            'data' => $data->items()
        ]);
    }
}
