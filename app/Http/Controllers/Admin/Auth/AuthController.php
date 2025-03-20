<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Actions\Admin\v1\Auth\GetMeAction;
use App\Actions\Admin\v1\Auth\LoginAction;
use App\Actions\Admin\v1\Auth\RefreshTokenAction;
use App\Dto\Admin\v1\Auth\LoginDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\v1\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/admin/v1/auth/login',
        description: "Admin login qiliw",
        tags: ["Auth Admin"],
        summary: "Admin login",
        security: [
            ['sanctum' => []]
        ]
    )]
    #[OA\RequestBody(
        required: true,
        description: "Login qiliw ushin kerekli mag'liwmatlar",
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
     * @param \App\Http\Requests\Admin\v1\Auth\LoginRequest $request
     * @param \App\Actions\Admin\v1\Auth\LoginAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return $action(LoginDto::from($request));
    }

    #[OA\Post(
        path: '/admin/v1/auth/refresh-token',
        description: "Access tokendi jan'alaw",
        tags: ["Auth Admin"],
        summary: "Refresh token",
        security: [
            ['sanctum' => []]
        ]
    )]
    #[OA\Response(response: 200, description: 'Token updated')]
    #[OA\Response(response: 401, description: 'Unauthorized')]
    /**
     * Summary of refreshToken
     * @param \App\Actions\Admin\v1\Auth\RefreshTokenAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(RefreshTokenAction $action): JsonResponse
    {
        return $action();
    }

    #[OA\Get(
        path: '/admin/v1/auth/me',
        description: "Usi paydalaniwshi haqqinda mag'liwmat aliw",
        tags: ["Auth Admin"],
        summary: "Get authenticated admin",
        security: [
            ['sanctum' => []]
        ]
    )]
    #[OA\Response(response: 200, description: 'OK')]
    #[OA\Response(response: 401, description: 'Unauthorized')]
    /**
     * Summary of me
     * @param \App\Actions\Admin\v1\Auth\GetMeAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(GetMeAction $action): JsonResponse
    {
        return $action();
    }

    #[OA\Post(
        path: '/admin/v1/auth/logout',
        description: "Admin sessiyasin juwmaqlaw",
        tags: ["Auth Admin"],
        summary: "Logout admin",
        security: [
            ['sanctum' => []]
        ]
    )]
    #[OA\Response(response: 200, description: 'Success')]
    #[OA\Response(response: 401, description: 'Unauthorized')]
    /**
     * Summary of logout
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();
        auth()->user()->tokens()->where('name', 'refresh token')->delete();

        return response()->json([
            'message' => "You're logout",
        ]);
    }
}
