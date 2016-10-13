<?php

namespace App\Http;

use App\Http\Middleware\AdminOrder;
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
        'admin' => \App\Http\Middleware\Admin::class,
        'admin_order' => \App\Http\Middleware\AdminOrder::class,
        'admin_discount' => \App\Http\Middleware\AdminDiscount::class,
        'admin_user_info' => \App\Http\Middleware\AdminUserInfo::class,
        'admin_color' => \App\Http\Middleware\AdminColor::class,
        'admin_brand' => \App\Http\Middleware\AdminBrand::class,
        'admin_size_chart' => \App\Http\Middleware\AdminSizeChart::class,
        'admin_categories' => \App\Http\Middleware\AdminCategories::class,
        'admin_size' => \App\Http\Middleware\AdminSize::class,
    ];
}
