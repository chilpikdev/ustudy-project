<?php

namespace Tests\Feature\Core\Comment;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class CommentTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * Summary of test_comment_can_create
     * @return void
     */
    public function test_comment_can_create(): void
    {
        $user = User::find(1);
        $this->actingAs($user);

        $post = Post::inRandomOrder()->first();

        $data = [
            'content' => "Test comment",
            'post_id' => $post->id,
        ];

        $response = $this->postJson("/api/core/v1/comment/create", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ])
            ->assertJson(['message' => 'Comment created!']);

        $this->assertDatabaseHas('comments', [
            'content' => 'Test comment',
        ]);
    }

    /**
     * Summary of test_comment_can_update
     * @return void
     */
    public function test_comment_can_update(): void
    {
        $user = User::find(1);
        $this->actingAs($user);

        $comment = Comment::inRandomOrder()->first();
        $data = [
            'content' => "New comment",
            'comment_id' => $comment->id,
        ];

        $response = $this->putJson("/api/core/v1/comment/update", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ])
            ->assertJson(['message' => 'Comment updated!']);

        $this->assertDatabaseHas('comments', [
            'content' => 'New comment',
        ]);
    }

    /**
     * Summary of test_comment_can_delete
     * @return void
     */
    public function test_comment_can_delete(): void
    {
        $user = User::find(1);
        $this->actingAs($user);

        $comment = Comment::inRandomOrder()->first();

        $response = $this->deleteJson("/api/core/v1/comment/delete/" . $comment->id);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ])
            ->assertJson(['message' => 'Comment deleted!']);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }
}
