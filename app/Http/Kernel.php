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
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            //[growcrm] make sure we have no session during setup
            \App\Http\Middleware\General\Setup::class,

            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            //[growcrm] [general middleware]
            \App\Http\Middleware\General\SanityCheck::class,
            //[growcrm] [general middleware]
            \App\Http\Middleware\General\General::class,
        ],

        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
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
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'passport' => \App\Http\Middleware\AppUser::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'authenticationMiddlewareGeneral' => \App\Http\Middleware\Authenticate\General::class,

        //[growcrm] - [general]
        'adminCheck' => \App\Http\Middleware\General\AdminCheck::class,
        'teamCheck' => \App\Http\Middleware\General\TeamCheck::class,
        'generalMiddleware' => \App\Http\Middleware\General\General::class,
        'demoModeCheck' => \App\Http\Middleware\General\DemoCheck::class,

        //[growcrm] - [milestone]
        'homeMiddlewareIndex' => \App\Http\Middleware\Home\Index::class,

        //[growcrm] - [settings]
        'settingsMiddlewareIndex' => \App\Http\Middleware\Settings\Index::class,

        //[showtec] - [clients]
        'clientsMiddlewareIndex' => \App\Http\Middleware\Clients\Index::class,

        //[showtec] - [leads]
        'leadsMiddlewareIndex' => \App\Http\Middleware\Leads\Index::class,
        'leadsMiddlewareCreate' => \App\Http\Middleware\Leads\Create::class,
        'leadsMiddlewareEdit' => \App\Http\Middleware\Leads\Edit::class,
        'leadsMiddlewareShow' => \App\Http\Middleware\Leads\Show::class,
        'leadsMiddlewareDestroy' => \App\Http\Middleware\Leads\Destroy::class,
        'leadsMiddlewareBulkEdit' => \App\Http\Middleware\Leads\BulkEdit::class,
        'leadsMiddlewareParticipate' => \App\Http\Middleware\Leads\Participate::class,
        'leadsMiddlewareDeleteAttachment' => \App\Http\Middleware\Leads\DeleteAttachment::class,
        'leadsMiddlewareDownloadAttachment' => \App\Http\Middleware\Leads\DownloadAttachment::class,
        'leadsMiddlewareDeleteComment' => \App\Http\Middleware\Leads\DeleteComment::class,
        'leadsMiddlewareEditDeleteChecklist' => \App\Http\Middleware\Leads\EditDeleteChecklist::class,
        'leadsMiddlewareAssign' => \App\Http\Middleware\Leads\Assign::class,
        'importLeadsMiddlewareCreate' => \App\Http\Middleware\Import\Leads\Create::class,

        //[showtec] - [projects]
        'projectsMiddlewareIndex' => \App\Http\Middleware\Projects\Index::class,

        //[showtec] - [projects]
        'inventoryMiddlewareIndex' => \App\Http\Middleware\Inventory\Index::class,
        
    ];
}
