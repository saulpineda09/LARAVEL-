<?php

namespace App\Providers;

use App\Business\Interfaces\MessageServiceInterface;
use App\Business\Services\EncryptService;
use App\Business\Services\HiServices;
use App\Business\Services\HiUserService;
use App\Business\Services\SingletonServices;
use App\Business\Services\UserService;
use App\Http\Controllers\InfoController;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
public function register(): void
{
    //esto es para que laravel sepa que cuando vea la interfaz MessageServiceInterface
    //debe inyectar la clase HiServices
    $this->app->bind(MessageServiceInterface::class, HiUserService::class); 
    $this->app->bind(EncryptService::class, function(){
        return new EncryptService(env("KEY_ENCRYPT"));
    });

    //registro del servicio UserService con su dependencia EncryptService
    $this->app->bind(UserService::class, function($app){
        return new UserService($app->make(EncryptService::class));
    });

    //inyeccion de dependencias especifica para el controlador InfoController
    $this->app->when(InfoController::class)
        ->needs(MessageServiceInterface::class)
        ->give(HiServices::class); 

    $this->app->singleton(SingletonServices::class, function($app){
        return new SingletonServices(); 
    });
}
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
