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
use OpenApi\Attributes as OA;


class PostController extends Controller
{
    #[OA\Get(path: '/core/v1/posts', tags: ["Posts Core"], summary: "Retrieve all posts", )]
    #[OA\Response(response: 200, description: 'Post collection with pagination')]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
    /**
     * Summary of posts
     */
    public function posts(IndexRequest $request, IndexAction $action): JsonResponse
    {
        return $action(IndexDto::from($request));
    }

    #[OA\Get(path: '/core/v1/posts/show/{slug}', summary: "Post by slug detail", tags: ["Posts Core"])]
    #[OA\Parameter(
        name: "slug",
        in: "path",
        required: true,
        description: "The slug of the post",
        schema: new OA\Schema(type: "string", example: "my-first-post")
    )]
    #[OA\Response(response: 200, description: 'Post by slug')]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
    /**
     * Summary of show
     */
    public function show(string $slug, ShowAction $action): JsonResponse
    {
        return $action($slug);
    }

    #[OA\Get(path: '/core/v1/posts/recommended', summary: "5 Latest recommended post", tags: ["Posts Core"])]
    #[OA\Response(response: 200, description: '5 Latest recommended post')]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
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
