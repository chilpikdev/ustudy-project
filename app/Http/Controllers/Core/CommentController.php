<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\v1\Comment\CreateAction;
use App\Actions\Core\v1\Comment\DeleteAction;
use App\Actions\Core\v1\Comment\UpdateAction;
use App\Dto\Core\v1\Comment\CreateDto;
use App\Dto\Core\v1\Comment\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\v1\Comment\CreateRequest;
use App\Http\Requests\Core\v1\Comment\UpdateRequest;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Summary of create
     * @param \App\Http\Requests\Core\v1\Comment\CreateRequest $request
     * @param \App\Actions\Core\v1\Comment\CreateAction $action
     * @return JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Core\v1\Comment\UpdateRequest $request
     * @param \App\Actions\Core\v1\Comment\UpdateAction $action
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action(UpdateDto::from($request));
    }

    /**
     * Summary of delete
     * @param int $id
     * @param \App\Actions\Core\v1\Comment\DeleteAction $action
     * @return JsonResponse
     */
    public function delete(int $id, DeleteAction $action): JsonResponse
    {
        return $action($id);
    }
}
