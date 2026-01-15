<?php
//Este archivo crea un comando de consola llamado app:hi que muestra un saludo cuando se ejecuta
namespace App\Console\Commands;

use Illuminate\Console\Command;

class Hi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //en {--Last Name=} se define una opcion opcional llamada Last Name
    protected $signature = 'app:hi {name : nombre de la persona} 
    {--LastName= : Apellido de la persona}
     {--uppercase : Indica si se desea el mensaje en mayusculas}'; //el comando recibe un argumento name

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muestra un saludo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //obtenemos el argumento name 
        $name = $this->argument('name'); 
        //Aqui se agrega la variable last name pero es opcional
        $LastName = $this->option('LastName');
        //creamos el mensaje de saludo
        $message = "Hola, {$name} {$LastName}"; 
        //this sirve para acceder a los metodos de la clase command
        $uppercase = $this->option('uppercase'); //uppercase es para mandar un mensaje opcional cuando se ejecuta el comando
        

        if($uppercase){
            $message = strtoupper($message); 
        }

        $this->info($message);
    }

    //Con esto cuando ejecutemos el comando app:hi tendremos que pasar un argumento name
    //por ejemplo php artisan app:hi Saul

    //Si queremos agregar la opcion last name seria asi
    //php artisan app:hi Saul --LastName=Pineda 

    //Uppercase es una bandera que solo devuelve true o false en caso de que no se envie 
    //devuelve false, y si se envia devuelve true 
}
