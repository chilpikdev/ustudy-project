<?php

namespace App\Dto\Admin\v1\Category;

use App\Http\Requests\Admin\v1\Category\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public string $name,
    ) {
    }

    public static function from(CreateRequest $request): self
    {
        return new self(
            name: $request->get('name'),
        );
    }
}
