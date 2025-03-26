<?php

namespace Tests\Feature\Core;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    // use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::find(1);

        $response = $this->postJson('/api/core/v1/auth/login', [
            'phone' => $user->phone,
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
                ],
            ]);
    }

    // TODO: Bul jerde registratsiyadan o'tiwdi test qilamiz
    // public function test_user_can_register() 
    // {
    //     $user = [
    //         "country_id"=> 1,
    //         "first_name"=> "Islam",
    //         "last_name"=> "Khaliev",
    //         "phone"=> 998937731818,
    //         "email"=> "test4@example.com",
    //         "password"=> "Isl@m12345678",
    //         "password_confirmation"=> "Isl@m12345678"
    //     ];

    //     $response = $this->postJson('/api/core/v1/auth/registration', $user);

    //     $response->assertStatus(200);
    // }

    // TODO: Bul jerde AcceptOtp 
    // public function test_user_can_accept_otp()
    // {
    //     $response = $this->postJson('/api/core/v1/auth/otp/accept', [
    //         'email' => 'test_user@example.com',
    //         'otp' => '123456',
    //     ]);

    //     $response->assertStatus(200)
    //         ->assertJson(['message' => 'OTP verified successfully']);
    // }

    // TODO: Bul jerde verify-email di tekseremiz
    // public function test_user_can_verify_email()
    // {
    //     $user = User::factory()->create();

    //     $response = $this->getJson("/api/core/v1/auth/email/verify/{id}");

    //     $response->assertStatus(200)
    //         ->assertJson(['message' => 'Email verified successfully']);
    // }
    
    public function test_authenticated_user_can_access_me_endpoint()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['access-token']);

        $response = $this->getJson('/api/core/v1/auth/me');

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

    public function test_authenticated_user_can_refresh_token()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['issue-access-token']);

        $response = $this->postJson('/api/core/v1/auth/refresh-token');

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

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['access-token']);

        $response = $this->postJson('/api/core/v1/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'You\'re logout']);
    }

}