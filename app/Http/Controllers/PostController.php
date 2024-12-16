<?php

namespace App\Http\Controllers;

use App\Actions\Core\v1\Posts\IndexAction;
use App\Dto\Core\v1\Posts\IndexDto;
use App\Http\Requests\Core\v1\Posts\IndexRequest;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{

    public function posts(IndexRequest $request, IndexAction $action): JsonResponse
    {
        return $action(IndexDto::from($request));
    }
}
