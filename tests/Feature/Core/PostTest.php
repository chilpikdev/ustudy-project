<?php

namespace Tests\Feature\Core;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostTest extends TestCase
{

    private $apiResponseFields = [
        'id',
        'title',
        'description',
        'view',
        'shared',
        'recommended',
        'tags' => [
            '*' => [
                'id',
                'name',
                'created_at',
                'updated_at'
            ]
        ],
        'category' => [
            'id',
            'name'
        ],
        'reading_time',
        'slug',
        'created_at'
    ];

    public function test_index_a_list_of_posts()
    {
        $response = $this->getJson('/api/core/v1/posts');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'items' => ['*' => $this->apiResponseFields],
                    'pagination' => [
                        'current_page',
                        'per_page',
                        'last_page',
                        'total'
                    ]
                ]
            ]);
    }

    public function test_search_from_a_list_of_posts()
    {
        // Post::factory()->create(['title' => 'Laravel Testing Guide']);  //refresh DB

        $response = $this->getJson('/api/core/v1/posts?search=Laravel');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'items' => ['*' => $this->apiResponseFields],
                    'pagination' => [
                        'current_page',
                        'per_page',
                        'last_page',
                        'total'
                    ]
                ]
            ])
            ->assertJsonPath('data.items.0.title', 'Laravel Testing Guide');
    }

    public function test_show_a_post()
    {
        $post = Post::factory()->create();
        $tags = Tag::inRandomOrder()->limit(2)->pluck('id');
        $post->tags()->attach($tags);

        $response = $this->getJson('/api/core/v1/posts/show/' . $post->slug);

        $response
            ->assertOk()
            ->assertJsonPath('data.slug', Str::slug($post->title))
            ->assertJsonStructure([
                'status',
                'message',
                'data' => $this->apiResponseFields
            ]);
    }
    public function test_show_a_post_with_error_slug()
    {
        $response = $this->getJson('/api/core/v1/posts/show/' . 'Test For slug');

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'status',
                'message'
            ]);
    }
    public function test_recommended_posts()
    {
        $response = $this->getJson('/api/core/v1/posts/recommended');

        $response
            ->assertOk()
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'user_id',
                        'category_id',
                        'title',
                        'description',
                        'content',
                        'view',
                        'shared',
                        'slug',
                    ]
                ]
            ]);
    }

    public function test_share_a_post()
    {

        $post = Post::inRandomOrder()->first();
        $shared = $post->shared;
        $response = $this->postJson('/api/core/v1/posts/share', ['post_id' => $post->id]);

        $response
            ->assertOk()
            ->assertJson([
                'status' => 200,
                'message' => 'Post shared',
            ]);
        $shared++;
        $post->refresh();

        $this->assertEquals($shared, $post->shared);
    }

    public function test_share_a_post_with_error_id()
    {

        $response = $this->postJson('/api/core/v1/posts/share', ['post_id' => -1]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 422,
                'errors' => [
                    "post_id" => [
                        "The selected post id is invalid."
                    ]
                ]
            ]);

    }
}