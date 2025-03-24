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
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{

    #[OA\Get(
        path: '/admin/v1/categories',
        description: "All categories",
        tags: ["Categories Admin"],
        summary: "All categories",
        security:   [['sanctum' => []]])]
    #[OA\Response(response: 200, description: 'Kategoriyalar dizimi')]
    #[OA\Response(response: 401, description: 'Not allowed')]
    #[OA\Response(response: 404, description: "Kategoriya tabilmadi")]
    /**
     * Display a listing of the resource.
     */
    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    #[OA\Post(
        path: '/admin/v1/categories/create',
        description: "Kategoriya jaratiw",
        tags: ["Categories Admin"],
        summary: "Kateogriya jaratiw",
        security: [['sanctum' => []]],
    )]
    #[OA\RequestBody(
        required: true,
        description: "Category jaratiw ushin mag'liwmatlar",
        content: new OA\JsonContent(
            required: ["name"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Jan'a category"),
            ]
        )
    )]
    #[OA\Response(response: 200, description: 'Kategoriya jaratiw')]
    #[OA\Response(response: 401, description: 'Not allowed')]
    #[OA\Response(response: 404, description: "Kategoriya tabilmadi")]

    /**
     * Store a newly created resource in storage.
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDto::from($request));
    }

    #[OA\Put(
        path: "/admin/v1/categories/update/{id}",
        summary: "Kategoriya jan'alaw",
        tags: ["Categories Admin"],
        security: [["sanctum" => []]],
        parameters: [new OA\Parameter(name: "id", in: "path", required: true,
        schema: new OA\Schema(type: "integer", example:1)
        )],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name"],
                properties: [new OA\Property(property: "name", type: "string", example: "Jan'a kotegoriya ati")]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Kategoriya jan'alandi"),
            new OA\Response(response: 401, description: "Not allowed"),
            new OA\Response(response: 404, description: "Kategoriya tabilmadi"),
        ]
    )]
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, int $id, UpdateAction $action)
    {
        return $action(UpdateDto::from($id, $request));
    }

    #[OA\Delete(
        path: "/admin/v1/categories/delete/{id}",
        summary: "Kategoriya o'shiriw",
        tags: ["Categories Admin"],
        security: [["sanctum" => []]],
        parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))],
        responses: [
            new OA\Response(response: 200, description: "Kategoriya o'shirildi"),
            new OA\Response(response: 401, description: "Not allowed"),
            new OA\Response(response: 404, description: "Kategoriya tabilmadi"),
        ]
    )]
    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id, DeleteAction $action)
    {
        return $action($id);
    }
}
