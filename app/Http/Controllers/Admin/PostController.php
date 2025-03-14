<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\v1\Posts\CreateAction;
use App\Actions\Admin\v1\Posts\DeleteAction;
use App\Actions\Admin\v1\Posts\IndexAction;
use App\Actions\Admin\v1\Posts\ShareAction;
use App\Actions\Admin\v1\Posts\ShowAction;
use App\Actions\Admin\v1\Posts\UpdateAction;
use App\Dto\Admin\v1\Posts\CreateDto;
use App\Dto\Admin\v1\Posts\IndexDto;
use App\Dto\Admin\v1\Posts\ShareDto;
use App\Dto\Admin\v1\Posts\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\v1\Category\UpdateRequest;
use App\Http\Requests\Admin\v1\Posts\CreateRequest;
use App\Http\Requests\Admin\v1\Posts\IndexRequest;
use App\Http\Requests\Admin\v1\Posts\ShareRequest;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Summary of index
     * @param \App\Http\Requests\Admin\v1\Posts\IndexRequest $request
     * @param \App\Actions\Admin\v1\Posts\IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexRequest $request, IndexAction $action): JsonResponse
    {
        return $action(IndexDto::from($request));
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\Admin\v1\Posts\CreateRequest $request
     * @param \App\Actions\Admin\v1\Posts\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\Admin\v1\Posts\ShowAction $action
     * @return JsonResponse
     */
    public function show(int $id, ShowAction $action): JsonResponse
    {
        return $action($id);
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Admin\v1\Posts\UpdateRequest $request
     * @param \App\Actions\Admin\v1\Posts\UpdateAction $action
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action(UpdateDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param \App\Actions\Admin\v1\Posts\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(int $id, DeleteAction $action): JsonResponse
    {
        return $action($id);
    }

    public function share(ShareRequest $request, ShareAction $action)
    {
        return $action(ShareDto::from($request));
    }
}
