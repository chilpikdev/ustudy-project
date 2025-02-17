<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Core\v1\Auth\Otp\AcceptAction;
use App\Dto\Core\v1\Auth\OtpAcceptDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\v1\Auth\OtpAcceptRequest;
use App\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

class OtpVerificationController extends Controller
{
    use ResponseTrait;

    /**
     * Summary of accept
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function accept(OtpAcceptRequest $request, AcceptAction $action): JsonResponse
    {
        return $action(OtpAcceptDto::from($request));
    }
}
