<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\v1\Posts\IndexAction;
use App\Actions\Core\v1\Posts\ShowAction;
use App\Dto\Core\v1\Posts\IndexDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\v1\Posts\IndexRequest;
use App\Services\PostService;
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
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function showRecommendedPosts(): JsonResponse
    {
        $posts = $this->postService->getLatestRecommendedPosts();
        return response()->json($posts);
    }
}
