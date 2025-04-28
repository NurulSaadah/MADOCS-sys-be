<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // Security Middleware
        \App\Http\Middleware\Cors::class, // Handle CORS policies
        \App\Http\Middleware\TrustProxies::class, // Trust proxy headers
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class, // Block access during maintenance
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, // Validate request size
        \App\Http\Middleware\TrimStrings::class, // Trim input strings
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, // Convert empty strings to null
        \Spatie\ResponseCache\Middlewares\CacheResponse::class, // Cache responses globally

        // Performance Middleware

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            'throttle:40,1', // Rate limit for web routes
            \App\Http\Middleware\EncryptCookies::class, // Encrypt cookies
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, // Queue cookies for response
            \Illuminate\Session\Middleware\StartSession::class, // Start session
            \Illuminate\View\Middleware\ShareErrorsFromSession::class, // Share session errors
            \App\Http\Middleware\VerifyCsrfToken::class, // CSRF protection
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Substitute route bindings
            \App\Http\Middleware\GzipMiddleware::class,
        ],
        
        'api' => [
            'throttle:100,1', // Allows 100 requests per minute for API
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // 'auth:api', // Require API token authentication for all API routes
            \App\Http\Middleware\GzipMiddleware::class,
            // 'jwt.auth', // JWT authentication middleware
            \Spatie\ResponseCache\Middlewares\CacheResponse::class, // Cache API responses
            // \App\Http\Middleware\EnforceApiHeaders::class, // Enforce API only
        ],
        'apiPublic' => [
            'throttle:60,1', // Allows 100 requests per minute for API
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Spatie\ResponseCache\Middlewares\CacheResponse::class, // Cache API responses
            \App\Http\Middleware\GzipMiddleware::class,
            // \App\Http\Middleware\EnforceApiHeaders::class, // Enforce API only
        ],
        'apiInternal' => [
            'throttle:100,1', // Allows 100 requests per minute for API
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'auth:api', // Require API token authentication for all API routes
            \App\Http\Middleware\GzipMiddleware::class,
            'jwt.auth', // JWT authentication middleware
            \Spatie\ResponseCache\Middlewares\CacheResponse::class, // Cache API responses
            \App\Http\Middleware\EnforceApiHeaders::class, // Enforce API only
        ],

    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'jwt.verify' => \App\Http\Middleware\JwtMiddleware::class, // JWT middleware
        'jwt.auth' => 'Tymon\JWTAuth\Middleware\GetUserFromToken',
        'jwt.refresh' => 'Tymon\JWTAuth\Middleware\RefreshToken',
        'cors' => \App\Http\Middleware\Cors::class, // Handle CORS
    ];
}
