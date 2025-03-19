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
use App\Http\Requests\Admin\v1\Posts\UpdateRequest;
use App\Http\Requests\Admin\v1\Posts\CreateRequest;
use App\Http\Requests\Admin\v1\Posts\IndexRequest;
use App\Http\Requests\Admin\v1\Posts\ShareRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class PostController extends Controller
{
    #[OA\Get(
        path: "/admin/v1/posts",
        summary: "Get filtered posts",
        tags: ["Posts Admin"],
        security: [
            [
                'sanctum' => []
            ]
        ],
        parameters: [
            new OA\Parameter(name: "search", in: "query", description: "nullable|string"),
            new OA\Parameter(name: "from", in: "query", description: "nullable|date y-m-d"),
            new OA\Parameter(name: "to", in: "query", description: "nullable|date y-m-d"),
            new OA\Parameter(name: "order_by", in: "query", description: "nullable|string"),
            new OA\Parameter(name: "sort", in: "query", description: "nullable|asc, desc"),
            new OA\Parameter(name: "perpage", in: "query", description: "nullable|int"),
            new OA\Parameter(name: "page", in: "query", description: "nullable|int")
        ]
    )]
    #[OA\Response(
        response: 200,
        description: "Successful Response",
        content: new OA\JsonContent(ref: "#/components/schemas/AdminIndexRequest")
    )]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
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

    #[OA\Post(
        path: '/admin/v1/posts/create',
        summary: "Create Post",
        tags: ["Posts Admin"],
        security: [
            [
                'sanctum' => []
            ]
        ]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\MediaType(
            mediaType: "multipart/form-data",
            schema: new OA\Schema(
                required: ["title", "description", "content", "files[]", "category_id"],
                properties: [
                    new OA\Property(property: "title", type: "string"),
                    new OA\Property(property: "description", type: "string"),
                    new OA\Property(property: "content", type: "string"),
                    new OA\Property(property: "recommended", type: "boolean", enum: ["1"], example: "--", nullable: true),
                    new OA\Property(property: "files[]", type: "array", maxItems: 5, items: new OA\Items(type: "string", format: "binary")),
                    new OA\Property(property: "tags[]", type: "array", items: new OA\Items(type: "integer"), example: []),
                    new OA\Property(property: "category_id", type: "integer")
                ]
            ),
            encoding: [
                "tags[]" => [
                    "style" => "form",
                    "explode" => true
                ],
                "files[]" => [
                    "style" => "form",
                    "explode" => true
                ],
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Post Created",
    )]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
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

    #[OA\Get(
        path: "/admin/v1/posts/show/{id}",
        summary: "Get Post Details",
        tags: ["Posts Admin"],
        security: [
            ["sanctum" => []]
        ],
    )]
    #[OA\Parameter(
        name: "id",
        description: "Post ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\Response(response: 200, description: "Post details")]
    #[OA\Response(response: 404, description: "Post not found")]
    #[OA\Response(response: 401, description: "Unauthenticated")]
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

    #[OA\Post(
        path: '/admin/v1/posts/update',
        summary: "Create Post",
        tags: ["Posts Admin"],
        security: [
            [
                'sanctum' => []
            ]
        ]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\MediaType(
            mediaType: "multipart/form-data",
            schema: new OA\Schema(
                required: ["id", "title", "description", "content", "recommended", "category_id", "_method"],
                properties: [
                    new OA\Property(property: "id", type: "integer"),
                    new OA\Property(property: "title", type: "string"),
                    new OA\Property(property: "description", type: "string"),
                    new OA\Property(property: "content", type: "string"),
                    new OA\Property(property: "recommended", type: "boolean", enum: ["0", "1"], example: "0", nullable: false),
                    new OA\Property(property: "files[]", type: "array", maxItems: 5, items: new OA\Items(type: "string", format: "binary"), example: []),
                    new OA\Property(property: "tags[]", type: "array", items: new OA\Items(type: "integer"), example: []),
                    new OA\Property(property: "category_id", type: "integer", example: 1),
                    new OA\Property(property: "_method", type: "string", enum: ["PUT"], example: "PUT", nullable: false),
                ]
            ),
            encoding: [
                "tags[]" => [
                    "style" => "form",
                    "explode" => true
                ],
                "files[]" => [
                    "style" => "form",
                    "explode" => true
                ],
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Post Updated",
    )]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
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

    #[OA\Delete(
        path: "/admin/v1/posts/delete/{id}",
        summary: "Delete Post Details",
        tags: ["Posts Admin"],
        security: [
            ["sanctum" => []]
        ],
    )]
    #[OA\Parameter(
        name: "id",
        description: "Post ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\Response(response: 200, description: "Post deleted")]
    #[OA\Response(response: 404, description: "Post not found")]
    #[OA\Response(response: 401, description: "Unauthenticated")]
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

    #[OA\Post(
        path: "/admin/v1/posts/share",
        summary: "Share Post",
        tags: ["Posts Admin"],
        security: [
            ["sanctum" => []]
        ],
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\MediaType(
            mediaType: "application/json",
            schema: new OA\Schema(
                type: "object",
                required: ["post_id"],
                properties: [
                    new OA\Property(property: "post_id", type: "integer", example: 1)
                ]
            )
        )
    )]
    #[OA\Response(response: 200, description: "Post shared")]
    #[OA\Response(response: 404, description: "Post not found")]
    #[OA\Response(response: 401, description: "Unauthenticated")]
    /**
     * Summary of share
     * @param \App\Http\Requests\Admin\v1\Posts\ShareRequest $request
     * @param \App\Actions\Admin\v1\Posts\ShareAction $action
     * @return JsonResponse
     */
    public function share(ShareRequest $request, ShareAction $action)
    {
        return $action(ShareDto::from($request));
    }
}
