<?php

namespace App\Dto\Admin\v1\Category;

use App\Http\Requests\Admin\v1\Category\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }

    public static function from(int $id, UpdateRequest $request): self
    {
        return new self(
            id: $id,
            name: $request->get('name'),
        );
    }
}
