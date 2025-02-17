<?php

namespace App\Http\Requests\Traits;

use App\Exceptions\ApiValidationException;
use Illuminate\Contracts\Validation\Validator;

trait FailedValidation
{
    /**
     * Handle a failed validation attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ApiValidationException($validator);
    }
}
