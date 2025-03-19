<?php

namespace App\Http\Controllers\Core\Auth;

use App\Actions\Core\v1\Auth\GetMeAction;
use App\Actions\Core\v1\Auth\LoginAction;
use App\Actions\Core\v1\Auth\RefreshTokenAction;
use App\Actions\Core\v1\Auth\RegistrationAction;
use App\Dto\Core\v1\Auth\LoginDto;
use App\Dto\Core\v1\Auth\RegistrationDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\v1\Auth\LoginRequest;
use App\Http\Requests\Core\v1\Auth\RegistrationRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/core/v1/auth/login',
        description: "Userdi login qiliw",
        tags: ["Posts Core"],
        summary: "User login",
        security: [
            ['sanctum' => []]
        ]
    )]
    #[OA\RequestBody(
        required: true,
        description: "Login qiliw ushin mag'liwmatlar",
        content: new OA\JsonContent(
            required: ["phone", "password"],
            properties: [
                new OA\Property(property: "phone", type: "numeric", example: "998981600609"),
                new OA\Property(property: "password", type: "string", example: "12345678")
            ]
        )
    )]
    #[OA\Response(response: 200, description: 'OK')]
    #[OA\Response(response: 401, description: 'Unauthorized')]
    /**
     * Summary of login
     * @param \App\Http\Requests\Core\v1\Auth\LoginRequest $request
     * @param \App\Actions\Core\v1\Auth\LoginAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return $action(LoginDto::from($request));
    }

    /**
     * Summary of registration
     * @param \App\Http\Requests\Core\v1\Auth\RegistrationRequest $request
     * @param \App\Actions\Core\v1\Auth\RegistrationAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function registration(RegistrationRequest $request, RegistrationAction $action): JsonResponse
    {
        return $action(RegistrationDto::from($request));
    }

    #[OA\Post(
        path: '/core/v1/auth/refreshToken',
        description: "Access tokendi jan'alaw",
        tags: ["Posts Core"],
        summary: "Refresh token",
        security: [
            ['sanctum' => []]
        ]
    )]
    #[OA\Response(response: 200, description: 'Token updated')]
    #[OA\Response(response: 401, description: 'Unauthorized')]
    /**
     * Summary of refreshToken
     * @param \App\Actions\Core\v1\Auth\RefreshTokenAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(RefreshTokenAction $action): JsonResponse
    {
        return $action();
    }

    #[OA\Get(
        path: '/core/v1/auth/me',
        description: "Usi user haqqinda mag'liwmat aliw",
        tags: ["Posts Core"],
        summary: "Get authenticated user",
        security: [
            ['sanctum' => []]
        ]
    )]
    #[OA\Response(response: 200, description: 'OK')]
    #[OA\Response(response: 401, description: 'Unauthorized')]
    /**
     * Summary of me
     * @param \App\Actions\Core\v1\Auth\GetMeAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(GetMeAction $action): JsonResponse
    {
        return $action();
    }

    #[OA\Post(
        path: '/core/v1/auth/logout',
        description: "Userdi logout qiliw",
        tags: ["Posts Core"],
        summary: "User logout",
        security: [
            ['sanctum' => []]
        ]
    )]
    #[OA\Response(response: 200, description: 'Succesfully')]
    #[OA\Response(response: 401, description: 'Unauthorized')]
    /**
     * Summary of logout
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => "You're logout",
        ]);
    }
}
