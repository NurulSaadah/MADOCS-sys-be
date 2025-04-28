<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        header("Access-Control-Allow-Origin: *");

        $headers = [
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS', // Remove PUT, DELETE if not used
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization',
            'Access-Control-Allow-Credentials' => 'true',  // Allow credentials (if needed)
            'Access-Control-Max-Age' => '3600',  // Cache the preflight response for 1 hour
        ];
        if ($request->getMethod() == "OPTIONS") {
            return response('OK',200)
                ->withHeaders($headers);
        }

        $response = $next($request);

        return $response->withHeaders($headers);
    }
}
