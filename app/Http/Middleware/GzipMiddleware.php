<?php

namespace App\Http\Middleware;

use Closure;

class GzipMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Only compress if the client accepts gzip encoding
        if (strpos($request->header('Accept-Encoding'), 'gzip') !== false) {
            $content = $response->getContent();
            $compressedContent = gzencode($content);

            $response->setContent($compressedContent);
            $response->header('Content-Encoding', 'gzip');
            $response->header('Vary', 'Accept-Encoding');
            $response->header('Content-Length', strlen($compressedContent));
        }

        return $response;
    }
}
