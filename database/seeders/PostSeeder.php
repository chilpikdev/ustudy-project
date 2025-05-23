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
            $post->tags()->attach($tags); // Posts jaratilg'anda ha'r bir postqa 1 den 3 ke shekem random tu'rde tag beredi
        });
    }
}
