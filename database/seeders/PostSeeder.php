<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory(100)->create()->each(function ($post) {
            $tags = Tag::inRandomOrder()->limit(rand(1,3))->pluck('id');
            $post->tags()->attach($tags);
        });
    }
}
