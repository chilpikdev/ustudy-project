<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\v1\Posts\IndexAction;
use App\Actions\Admin\v1\Posts\ShowAction;
use App\Dto\Admin\v1\Posts\IndexDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\v1\Posts\IndexRequest;
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
}
