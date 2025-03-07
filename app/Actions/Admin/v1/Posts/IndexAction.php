<?php

namespace App\Actions\Admin\v1\Posts;

use App\Actions\Traits\GenerateKeyCacheTrait;
use App\Dto\Admin\v1\Posts\IndexDto;
use App\Http\Resources\Admin\v1\Posts\PostCollection;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use GenerateKeyCacheTrait, ResponseTrait;

    public function __invoke(IndexDto $dto): JsonResponse
    {
        $data = Cache::remember('posts' . $this->generateKey(), now()->addDay(), function () use ($dto) {
            $items = Post::query();

            if ($dto->search) {
                $items
                    ->where('title', 'LIKE', '%' . $dto->search . '%')
                    ->orWhere('description', 'LIKE', '%' . $dto->search . '%');
            }

            if ($dto->from) {
                $items->whereBetween('created_at', [$dto->from, $dto->to]);
            }

            switch ($dto->orderBy) {
                case 'id':
                case 'title':
                case 'description':
                case 'recommended':
                case 'created_at':
                    $items->orderBy($dto->orderBy, $dto->sort);
                    break; 
                case 'category': 
                    $items->join('categories', 'posts.category_id', '=', 'categories.id')
                            ->orderBy('categories.name', $dto->sort)
                            ->select('posts.*'); 
                    break;
                default:
                    $items->orderByDesc('created_at');
            }

            return $items->paginate(perPage: $dto->perPage, page: $dto->page);
        });

        return static::toResponse(
            data: [
                'items' => new PostCollection($data),
                'pagination' => [
                    'current_page' => $data->currentPage(),
                    'per_page' => $data->perPage(),
                    'last_page' => $data->lastPage(),
                    'total' => $data->total(),
                ],
            ],
        );
    }
}
