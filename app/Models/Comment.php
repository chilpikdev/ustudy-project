<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Comment",
    description: "Comment modeli",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "content", type: "string", example: "Kommentariya"),
        new OA\Property(property: "user_id", type: "string", example: 1),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ]
)]
class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'content',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of commentable
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
