<?php

namespace App\Http\Controllers;

use App\Actions\Core\v1\Posts\IndexAction;
use App\Actions\Core\v1\Posts\ShowAction;
use App\Dto\Core\v1\Posts\IndexDto;
use App\Http\Requests\Core\v1\Posts\IndexRequest;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Summary of posts
     * @param \App\Http\Requests\Core\v1\Posts\IndexRequest $request
     * @param \App\Actions\Core\v1\Posts\IndexAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function posts(IndexRequest $request, IndexAction $action): JsonResponse
    {
        return $action(IndexDto::from($request));
    }

    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\Core\v1\Posts\ShowAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }
}
