<?php

namespace App\Actions\Admin\v1\Auth;

use App\Http\Resources\Admin\v1\Auth\GetMeResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class GetMeAction
{
    use ResponseTrait;

    public function __invoke(): JsonResponse
    {
        return static::toResponse(
            data: new GetMeResource(auth()->user())
        );
    }
}
