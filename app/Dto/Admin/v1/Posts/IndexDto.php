<?php

namespace App\Dto\Admin\v1\Posts;

use App\Http\Requests\Admin\v1\Posts\IndexRequest;

readonly class IndexDto
{
    public function __construct(
        public ?int $perPage,
        public ?int $page,
        public ?string $search,
        public ?string $from,
        public ?string $to,
        public ?string $orderBy,
        public ?string $sort,
    ) {
    }

    public static function from(IndexRequest $request): self
    {
        return new self(
            perPage: $request->get('perpage'),
            page: $request->get('page'),
            search: $request->get('search'),
            from: $request->get('from'),
            to: $request->get('to'),
            orderBy: $request->get('order_by'),
            sort: $request->get('sort'),
        );
    }
}
