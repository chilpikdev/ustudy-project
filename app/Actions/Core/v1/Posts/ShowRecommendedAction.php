<?php 

namespace App\Actions\Core\v1\Posts;

use App\Models\Post;
use App\Traits\ResponseTrait;

class ShowRecommendedAction
{
    use ResponseTrait;
    
    public function showLatestRecommendedPosts()
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