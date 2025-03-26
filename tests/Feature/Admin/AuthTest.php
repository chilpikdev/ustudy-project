<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    // use RefreshDatabase;

    public function test_admin_can_login_with_valid_credentials()
    {
        $admin = User::find(1);

        $response = $this->postJson('/api/admin/v1/auth/login', [
            'phone' => $admin->phone,
            'password' => '12345678',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'access_token',
                    'refresh_token',
                    'at_expired_at',
                    'rf_expired_at',
                ]
            ]);
    }

    public function test_authenticated_admin_can_access_me_endpoint()
    {
        $admin = User::factory()->create();

        Sanctum::actingAs($admin, ['*']);

        $response = $this->getJson('/api/admin/v1/auth/me');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',  
                'message',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'country',
                    'email_verified_at',
                    'created_at',
                    'roles',
                    'permissions',
                ],
            ]);
    }

    public function test_admin_can_refresh_token()
    {
        $admin = User::factory()->create();
        Sanctum::actingAs($admin, ['issue-access-token']);

        $response = $this->postJson('/api/admin/v1/auth/refresh-token');

        $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'access_token',
                'at_expired_at',
            ],
        ]);
    }

      public function test_admin_can_logout()
    {
        $admin = User::factory()->create();
        Sanctum::actingAs($admin, ['*']);

        $response = $this->postJson('/api/admin/v1/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'You\'re logout']);
    }
}