<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    /**
     * Summary of toResponse
     * @param int $code
     * @param mixed $message
     * @param object|array|null $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function toResponse(int $code = 200, ?string $message = null, object|array|null $data = null): JsonResponse
    {
        $responseData = [
            'status' => $code,
            'message' => $message,
        ];

        if ($data) {
            $responseData['data'] = $data;
        }

        return response()->json($responseData, $code);
    }
}
