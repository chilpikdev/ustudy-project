<?php

namespace App\Dto\Core\v1\Posts;

use App\Http\Requests\Core\v1\Posts\IndexRequest;

class IndexDto
{
    public function __construct(
        public ?int $perPage,
        public ?int $page,
        public ?string $search,
        public ?string $from,
        public ?string $to,
        public ?string $sort,
    ) {}

    public static function from(IndexRequest $request): self
    {
        return new self(
            perPage: $request->get('perpage'),
            page: $request->get('page'),
            search: $request->get('search'),
            from: $request->get('from'),
            to: $request->get('to'),
            sort: $request->get('sort'),
        );
    }
}
