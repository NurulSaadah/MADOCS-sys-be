<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnforceApiHeaders
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
        if (!$request->expectsJson()) {
            return response()->json(['message' => 'Invalid access. API requests only.'], 403);
        }

        return $next($request);
    }
}
