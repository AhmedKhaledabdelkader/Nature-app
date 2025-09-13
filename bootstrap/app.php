<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {


        $middleware->alias([
        
            'validate.company' => \App\Http\Middleware\ValidateCompany::class,
            'validate.impact'=>\App\Http\Middleware\ValidateImpact::class,
            'validate.project'=>\App\Http\Middleware\ValidateProject::class,
            'validate.country'=>\App\Http\Middleware\ValidateCountry::class,
            'validate.partner'=>\App\Http\Middleware\ValidatePartner::class,
            'validate.theme'=>\App\Http\Middleware\ValidateTheme::class,
            'localize'=>\App\Http\Middleware\LocalizationMiddleware::class

            
]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
