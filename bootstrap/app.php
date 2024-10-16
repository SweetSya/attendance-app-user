<?php

use App\Http\Middleware\RefreshDeviceUUID;
use App\Http\Middleware\VerifyDeviceUUID;
use App\Http\Middleware\VerifySessionAuthentication;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'verify_auth_session' => VerifySessionAuthentication::class,
            'refresh_device_uuid' => RefreshDeviceUUID::class,
            'verify_device_uuid' => VerifyDeviceUUID::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
