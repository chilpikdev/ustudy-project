<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiJson
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accept = $request->headers->get('Accept');

        if ($accept === null || $accept === '*/*' || $accept === 'application/*') {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
