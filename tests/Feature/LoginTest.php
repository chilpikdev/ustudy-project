<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_can_login(): void
    {
        $user = User::create([
            'country_id' => Country::inRandomOrder()->first()->id,
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test_user@example.com',
            'email_verified_at' => now(),
            'phone' => '998981600606',
            'phone_verified_at' => now(),
            'password' => 'Isl@m1995',
        ]);

        $response = $this->postJson('/api/core/v1/auth/login', [
            'phone' => 998981600606,
            'password' => 'Isl@m1995',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'access_token',
                    'refresh_token',
                    'at_expired_at',
                    'rf_expired_at',
                ],
            ]);

        Sanctum::actingAs($user);
        $this->assertAuthenticatedAs($user);
    }
}
