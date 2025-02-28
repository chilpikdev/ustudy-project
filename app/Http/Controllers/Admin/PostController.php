<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\v1\Posts\CreateAction;
use App\Actions\Admin\v1\Posts\DeleteAction;
use App\Actions\Admin\v1\Posts\IndexAction;
use App\Actions\Admin\v1\Posts\ShowAction;
use App\Actions\Admin\v1\Posts\UpdateAction;
use App\Dto\Admin\v1\Posts\CreateDto;
use App\Dto\Admin\v1\Posts\IndexDto;
use App\Dto\Admin\v1\Posts\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\v1\Posts\CreateRequest;
use App\Http\Requests\Admin\v1\Posts\IndexRequest;
use App\Http\Requests\Admin\v1\Posts\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function upload(Request $request)
    {
        $contentType = $request->header('Content-Type');
        $binaryFile = file_get_contents('php://input');

        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'application/pdf' => 'pdf',
            'text/plain' => 'txt'
        ];

        $fileName = uniqid('upload_', true) . '.' . $extensions[$contentType];

        \Storage::disk('public')->put("uploads/{$fileName}", $binaryFile);

        dd($fileName);
    }
}
