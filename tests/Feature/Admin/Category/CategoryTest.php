<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * Summary of test_category_can_create
     * @return void
     */
    public function test_category_can_create(): void
    {
        $user = User::find(1);
        $this->actingAs($user);

        $name = fake()->name();
        $data = [
            'name' => $name
        ];

        $response = $this->postJson("/api/admin/v1/categories/create", $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ])
            ->assertJson(['message' => 'Category created']);

        $this->assertDatabaseHas('categories', [
            'name' => $name,
        ]);
    }

    /**
     * Summary of test_category_can_get_all
     * @return void
     */
    public function test_category_can_get_all(): void
    {
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->getJson("/api/admin/v1/categories");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);
    }

    /**
     * Summary of test_category_can_update
     * @return void
     */
    public function test_category_can_update(): void
    {
        $user = User::find(1);
        $this->actingAs($user);

        $category = Category::inRandomOrder()->first();

        $name = fake()->name();

        $data = [
            'name' => $name,
        ];

        $response = $this->putJson("/api/admin/v1/categories/update/" . $category->id, $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ])
            ->assertJson(['message' => 'Category updated']);

        $this->assertDatabaseHas('categories', [
            'name' => $name,
        ]);
    }

    /**
     * Summary of test_category_can_delete
     * @return void
     */
    public function test_category_can_delete(): void
    {
        $user = User::find(1);
        $this->actingAs($user);

        $category = Category::inRandomOrder()->whereNull('deleted_at')->first();

        $response = $this->deleteJson("/api/admin/v1/categories/delete/" . $category->id);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ])
            ->assertJson(['message' => 'Category deleted']);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
            'deleted_at' => null,
        ]);
    }
}
