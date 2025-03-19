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
use OpenApi\Attributes as OA;

class CommentController extends Controller
{
    #[OA\Post(
        path: '/core/v1/comment/create',
        description: "Kommentariya jaratiw",
        tags: ["Comments Core"],
        summary: "Kommentariya jaratiw",
        security: [['sanctum' => []]]
    )]
    #[OA\RequestBody(
        required: true,
        description: "Kommentariya jaratiw ushin mag'liwmatlar",
        content: new OA\JsonContent(
            required: ["content", "post_id"],
            properties: [
                new OA\Property(property: "content", type: "string", example: "Jan'a kommentariya"),
                new OA\Property(property: "post_id", type: "integer", example: 1),
            ]
        )
    )]
    #[OA\Response(response: 200, description: 'Kommentariya jaratildi')]
    #[OA\Response(response: 401, description: 'Not allowed')]
    #[OA\Response(response: 404, description: "Kommentariya tabilmadi")]
    /**
     * Store a newly created resource in storage.
     */
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

    #[OA\Put(
        path: "/core/v1/comment/update",
        summary: "Kommentariyani jan'alaw",
        tags: ["Comments Core"],
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["content", "post_id"],
                properties: [
                    new OA\Property(property: "content", type: "string", example: "Jan'a kotegoriya jaziw"),
                    new OA\Property(property: "comment_id", type: "integer", example: 1),
                    ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Kommentariya jan'alandi", content: new OA\JsonContent(ref: "#/components/schemas/Category")),
            new OA\Response(response: 401, description: "Not allowed"),
            new OA\Response(response: 404, description: "Kategoriya tabilmadi")
        ]
    )]
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

    #[OA\Delete(
        path: "/core/v1/comment/delete/{id}",
        summary: "Kommentariyani o'shiriw",
        tags: ["Comments Core"],
        security: [["sanctum" => []]],
        parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))],
        responses: [
            new OA\Response(response: 200, description: "Kommentariya o'shirildi"),
            new OA\Response(response: 401, description: "Not allowed"),
            new OA\Response(response: 404, description: "Kommentariya tabilmadi"),
        ]
    )]
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
