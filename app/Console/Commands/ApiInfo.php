<?php

namespace App\Console\Commands;

use App\ExternalService\ApiService;
use Illuminate\Console\Command;

class ApiInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:api-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta api tercera';
    
    public function __construct(protected ApiService $apiService){
        parent::__construct(); // Llama al constructor de la clase padre
        //la clase padre es Command
    }
    
    /**
     * Execute the console command.
     */
    public function handle()
    {
       $jsonString = json_encode($this->apiService->getData()); 
       $this->info($jsonString); 
       //el metodo info es para mostrar informacion en la consola 
    }
}
