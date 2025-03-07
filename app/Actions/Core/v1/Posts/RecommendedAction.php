<?php 

namespace App\Actions\Core\v1\Posts;

use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class RecommendedAction
{
    use ResponseTrait;
    
    /**
     * Summary of __invoke
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $posts = Post::where('recommended', true)
                       ->latest() 
                       ->limit(5)
                       ->get();

        return static::toResponse(
            data: $posts,
        );
   }

}