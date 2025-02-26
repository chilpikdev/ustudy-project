<?php

namespace App\Dto\Admin\v1\Posts;

use App\Http\Requests\Admin\v1\Posts\UpdateRequest;

readonly class UpdateDto
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $content,
        public bool $recommended,
        public ?array $files,
    ) {
    }

    public static function from(UpdateRequest $request): self
    {
        return new self(
            id: $request->get('id'),
            title: $request->get('title'),
            description: $request->get('description'),
            content: $request->get('content'),
            recommended: $request->get('recommended'),
            files: $request->file('files'),
        );
    }
}
