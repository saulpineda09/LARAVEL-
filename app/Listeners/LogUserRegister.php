<?php

namespace App\Listeners;

use App\Events\UserRegister;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogUserRegister implements ShouldQueue
{
    use InteractsWithQueue; 
    public $tries = 3; //numero de intentos 

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegister $event): void
    {

        $this->release(5); //esperar 5 segundos antes de reintentar 
        //Simulamos un error para probar los reintentos
        throw new Exception("Ocurrio un error al registrar al usuario", 1);
        
        //Agregamos un log para registrar el nuevo usuario
       // Log::info("Nuevo usuario registrado", ["id"=> $event->user->id]);
    }

    //este metodo se ejecuta cuando se agotan todos los intentos
    public function failed(UserRegister $event, $exception){
        Log::critical("El registro en el log del usuario {$event->user["id"]} ha fallado definitivamente");
    }
}
