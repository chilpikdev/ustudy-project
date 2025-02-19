<?php

namespace App\Http\Controllers\Core\Auth;

use App\Exceptions\ApiResponseException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmailVerificationController extends Controller
{
    use ResponseTrait;

    /**
     * Verify Email
     */
    public function verify(Request $request): JsonResponse
    {
        try {
            if (! $request->hasValidSignature()) {
                return static::toResponse(
                    code: 410,
                    message: 'Verification link is expired',
                );
            }

            $user = User::findOrFail($request->id);

            if (! $user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }

            return static::toResponse(
                message: "Email addressin'izdi a'wmetli tastiyiqladin'iz!"
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('User not found', 404);
        }
    }

    /**
     * Resend Email Verification
     */
    public function resend(): JsonResponse
    {
        $user = auth()->user();

        if ($user->hasVerifiedEmail()) {
            return static::toResponse(
                message: 'User already is verified'
            );
        }

        $user->sendEmailVerificationNotification();

        return static::toResponse(
            message: 'Verfication link resended'
        );
    }
}
