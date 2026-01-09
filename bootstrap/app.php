<?php

use App\Http\Middleware\checkValueInHeder;
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
    ->withMiddleware(function (Middleware $middleware): void {
        //$middleware ->append(checkValueInHeder::class); // de esta manera el middelware es globla y ya funciona
        
        //esto es para agregarle un alias al middleware 
        $middleware ->alias([
            "checkValue" =>checkValueInHeder::class
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
