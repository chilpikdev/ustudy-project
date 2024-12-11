<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiValidationException extends Exception
{
    public function __construct(
        protected Validator $validator
    ) {}

    /**
     * Summary of render
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'status' => 422,
            'errors' => $this->validator->errors()
        ], 422);
    }
}
