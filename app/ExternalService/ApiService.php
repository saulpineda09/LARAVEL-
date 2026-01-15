<?php

namespace App\ExternalService;

use App\ExternalService\Events\DataGet;
use Illuminate\Support\Facades\Http;


class ApiService{
    protected string $url; 

    public function __construct(string $url){
        $this->url = $url; 
    }

    public function getData(){
        //el metodo withoutVerifying es para evitar errores de certificado ssl en caso de que la api externa no tenga un certificado valido
          $response = Http::withoutVerifying()->get($this->url); 

          if($response->successful()){
            event(new DataGet($response->json())); 
            return $response->json(); 
          }
          return ["error" => "No se pudo obtener la informacion"]; 
    }

}