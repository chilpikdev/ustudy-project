<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    public function getLatestRecommendedPosts($limit = 5)
    {
        return Post::recommended()
                    ->latest()
                    ->take($limit)
                    ->get();
    }
}