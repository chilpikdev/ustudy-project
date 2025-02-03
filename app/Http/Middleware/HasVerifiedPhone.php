<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiResponseException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasVerifiedPhone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->user()->hasVerifiedPhone()) {
            throw new ApiResponseException("Telefon nomer tastiyiqlanbag'an", 403);
        }

        return $next($request);
    }
}
