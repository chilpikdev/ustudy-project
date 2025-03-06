<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\v1\Category\CreateAction;
use App\Actions\Admin\v1\Category\DeleteAction;
use App\Actions\Admin\v1\Category\IndexAction;
use App\Actions\Admin\v1\Category\UpdateAction;
use App\Dto\Admin\v1\Category\CreateDto;
use App\Dto\Admin\v1\Category\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\v1\Category\CreateRequest;
use App\Http\Requests\Admin\v1\Category\UpdateRequest;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, int $id, UpdateAction $action)
    {
        return $action(UpdateDto::from($id, $request));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id, DeleteAction $action)
    {
        return $action($id);
    }
}
