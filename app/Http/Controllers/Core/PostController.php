<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\v1\Posts\IndexAction;
use App\Actions\Core\v1\Posts\ShareAction;
use App\Actions\Core\v1\Posts\ShowAction;
use App\Actions\Core\v1\Posts\RecommendedAction;
use App\Dto\Core\v1\Posts\IndexDto;
use App\Dto\Core\v1\Posts\ShareDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\v1\Posts\IndexRequest;
use App\Http\Requests\Core\v1\Posts\ShareRequest;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Summary of posts
     */
    public function posts(IndexRequest $request, IndexAction $action): JsonResponse
    {
        return $action(IndexDto::from($request));
    }

    /**
     * Summary of show
     */
    public function show(string $slug, ShowAction $action): JsonResponse
    {
        return $action($slug);
    }

    /**
     * Summary of recommended
     * @param \App\Actions\Core\v1\Posts\RecommendedAction $action
     * @return JsonResponse
     */
    public function recommended(RecommendedAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of share
     * @param \App\Http\Requests\Core\v1\Posts\ShareRequest $request
     * @param \App\Actions\Core\v1\Posts\ShareAction $action
     * @return JsonResponse
     */
    public function share(ShareRequest $request, ShareAction $action)
    {
        return $action(ShareDto::from($request));
    }
}
