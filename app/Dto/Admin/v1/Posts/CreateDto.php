<?php

namespace App\Dto\Admin\v1\Posts;

use App\Http\Requests\Admin\v1\Posts\CreateRequest;

readonly class CreateDto
{
    public function __construct(
        public string $title,
        public string $description,
        public string $content,
        public ?bool $recommended,
        public array $files,
    ) {
    }

    public static function from(CreateRequest $request): self
    {
        return new self(
            title: $request->get('title'),
            description: $request->get('description'),
            content: $request->get('content'),
            recommended: $request->get('recommended'),
            files: $request->file('files'),
        );
    }
}
