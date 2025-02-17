<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    /**
     * Summary of toResponse
     *
     * @param  mixed  $message
     */
    public static function toResponse(int $code = 200, ?string $message = null, object|array|null $data = null, ?int $ttl = null): JsonResponse
    {
        $responseData = [
            'status' => $code,
            'message' => $message,
        ];

        if ($data) {
            $responseData['data'] = $data;
        }

        if ($ttl) {
            $responseData['ttl'] = $ttl;
        }

        return response()->json($responseData, $code);
    }
}
