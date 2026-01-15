<?php

namespace App\Providers;

use App\ExternalService\ApiService;
use App\ExternalService\Events\DataGet;
use App\ExternalService\Listeners\LogDataGet;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event; 

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //esto es para registrar el servicio en el contenedor de servicios
        //el contenedor se encarga de crear y gestionar las instancias de las clases
        $this->app->singleton(ApiService::class, function ($app){
            $url= config("services.api.url"); //obtenemos la url desde el archivo de configuracion services luego en la variable api.url 
            //esto se carga desde el cache y es mas rapido 
            return new ApiService($url);  
        }); 
    }

    /**
     * Bootstrap services.
     */

    //el metodo boot se ejecuta despues de que todos los servicios han sido registrados 
    //osea despues del metodo register
    public function boot(): void
    {
        Route::get("/api/posts", function(ApiService $apiService ){
           return response()->json($apiService->getData()); 
        }); 

        //esto es para registrar el listener del evento DataGet 
        //es un listener que escucha el evento DataGet y ejecuta la clase LogDataGet
        //un listener es una clase que se encarga de manejar un evento
        Event::listen(DataGet::class, LogDataGet::class); 
    }
}
