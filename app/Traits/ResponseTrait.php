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

        if (is_object($data) && property_exists($data, 'resource')) {
            if ($data->resource instanceof \Illuminate\Pagination\Paginator || $data->resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {
                $responseData['meta'] = [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                ];
            }
        }

        return response()->json($responseData, $code);
    }
}
