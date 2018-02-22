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
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Illuminate\Foundation\Http\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'acceso1' => \App\Http\Middleware\Acceso1::class,
        'acceso2' => \App\Http\Middleware\Acceso2::class,
        'acceso3' => \App\Http\Middleware\Acceso3::class,
        'acceso4' => \App\Http\Middleware\Acceso4::class,
        'acceso5' => \App\Http\Middleware\Acceso5::class,
        'acceso6' => \App\Http\Middleware\Acceso6::class,
        'acceso7' => \App\Http\Middleware\Acceso7::class,
        'acceso8' => \App\Http\Middleware\Acceso8::class,
        'acceso9' => \App\Http\Middleware\Acceso9::class,
        'acceso10' => \App\Http\Middleware\Acceso10::class,
        'acceso11' => \App\Http\Middleware\Acceso11::class,
        'acceso12' => \App\Http\Middleware\Acceso12::class,
        'acceso13' => \App\Http\Middleware\Acceso13::class,
        'acceso14' => \App\Http\Middleware\Acceso14::class,
        'acceso15' => \App\Http\Middleware\Acceso15::class,
        'acceso16' => \App\Http\Middleware\Acceso16::class,
        'acceso17' => \App\Http\Middleware\Acceso17::class,
    ];
}
