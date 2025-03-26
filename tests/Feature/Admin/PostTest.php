<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::find(1)->first();
        Sanctum::actingAs($user, ['*']);

        Storage::fake('public');
    }
    private $apiResponseFields = [
        'id',
        'title',
        'recommended',
        'description',
        'shared',
        'category' => [
            'id',
            'name'
        ],
        'reading_time',
    ];

    public function test_index_a_list_of_posts()
    {
        $response = $this->getJson('/api/admin/v1/posts');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'items' => ['*' => array_merge($this->apiResponseFields, ['created_at'])],
                    'pagination' => [
                        'current_page',
                        'per_page',
                        'last_page',
                        'total'
                    ]
                ]
            ]);
    }

    public function test_create_a_post()
    {
        $tags = Tag::inRandomOrder()->limit(2)->pluck('id')->toArray();

        $title = "Test Post Title " . Str::random(10);

        $data = [
            'title' => $title,
            'description' => 'Test Post Description',
            'content' => 'Test Post Content',
            'recommended' => true,
            'category_id' => 1,
            'tags' => $tags,
            'files' => [
                UploadedFile::fake()->image('img1.jpg'),
                UploadedFile::fake()->image('img2.jpg'),
            ],
        ];

        $response = $this->postJson('/api/admin/v1/posts/create', $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Post created',
            ]);

        $post = Post::where('title', $title)->first();

        //check created post
        $this->assertNotNull($post);

        // check tags
        $this->assertEqualsCanonicalizing(
            $data['tags'],
            $post->tags->pluck('id')->toArray()
        );

        //check file
        foreach ($post->files() as $file) {
            Storage::disk('public')->assertExists($file->path);
        }
    }

    public function test_create_a_post_without_title()
    {
        $tags = Tag::inRandomOrder()->limit(2)->pluck('id')->toArray();

        $data = [
            'description' => 'Test Post Description',
            'content' => 'Test Post Content',
            'recommended' => true,
            'category_id' => 1,
            'tags' => $tags,
            'files' => [
                UploadedFile::fake()->image('img1.jpg'),
                UploadedFile::fake()->image('img2.jpg'),
            ],
        ];

        $response = $this->postJson('/api/admin/v1/posts/create', $data);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'status',
                'errors' => ['title'],
            ]);
    }
    public function test_show_a_post()
    {
        $post = Post::inRandomOrder()->first();

        $response = $this->getJson('/api/admin/v1/posts/show/' . $post->id);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'message',
                'data' => array_merge($this->apiResponseFields, [
                    'view',
                    'files' => [
                        '*' => [
                            'id',
                            'name',
                            'size',
                            'extension',
                            'uploaded_at',
                        ]
                    ],
                ]),
            ]);
    }

    public function test_update_a_post()
    {

        $title = "Test Post Title " . Str::random(10);

        $data = [
            'id' => 2,
            'title' => $title,
            'description' => 'Test Post Description',
            'content' => 'Test Post Content',
            'recommended' => true,
            'category_id' => 1,
        ];

        $response = $this->putJson('/api/admin/v1/posts/update', $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Post updated',
            ]);

        $post = Post::where('title', $title)->first();

        //check updated post
        $this->assertNotNull($post);
    }

    public function test_delete_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson('/api/admin/v1/posts/delete/' . $post->id);

        $response->assertOk()
            ->assertJson([
                'status' => 200,
                'message' => 'Post deleted',
            ]);

        $this->assertSoftDeleted('posts', [
            'id' => $post->id,
        ]);
    }
}