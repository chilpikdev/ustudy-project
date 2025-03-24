<?php

namespace App\Http\Requests\Admin\v1\Posts;

use App\Http\Requests\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "AdminIndexRequest",
    type: "object",
    properties: [
        new OA\Property(property: "status", type: "integer", example: 200),
        new OA\Property(property: "message", type: "string", nullable: true, example: null),
        new OA\Property(property: "data", type: "object",
            properties: [
                new OA\Property(property: "items", type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "id", type: "integer", example: 105),
                            new OA\Property(property: "title", type: "string", example: "Yangi post"),
                            new OA\Property(property: "description", type: "string", example: "Post description"),
                            new OA\Property(property: "recommended", type: "boolean", example: false),
                            new OA\Property(property: "shared", type: "integer", example: 0),
                            new OA\Property(property: "category", type: "object",
                                properties: [
                                    new OA\Property(property: "id", type: "integer", example: 1),
                                    new OA\Property(property: "name", type: "string", example: "Technology"),
                                ]
                            ),
                            new OA\Property(property: "reading_time", type: "integer", example: 1),
                            new OA\Property(property: "created_at", type: "string", format: "datetime", example: "2025-03-18 10:41:41"),
                        ]
                    )
                ),
                new OA\Property(property: "pagination", type: "object",
                    properties: [
                        new OA\Property(property: "current_page", type: "integer", example: 1),
                        new OA\Property(property: "per_page", type: "integer", example: 15),
                        new OA\Property(property: "last_page", type: "integer", example: 7),
                        new OA\Property(property: "total", type: "integer", example: 103),
                    ]
                ),
            ]
        )
    ]
)]

class IndexRequest extends FormRequest
{
    use FailedValidation;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'perpage' => 'nullable|integer|min:1|max:50',
            'page' => ['nullable', 'integer', 'min:1'],
            'search' => 'nullable|string|min:4',
            'from' => 'nullable|date|date_format:Y-m-d|required_with:to',
            'to' => 'nullable|date|date_format:Y-m-d|required_with:from',
            'order_by' => 'nullable|string',
            'sort' => 'nullable|string|in:asc,desc|required_with:order_by',
        ];
    }
}
