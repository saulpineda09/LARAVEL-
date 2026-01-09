<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\log; 

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $data=[
            'url'=>$request->fullUrl(), //retorna la url 
            'ip'=> $request->ip(),//retorna la ip del cliente que hizo la peticion
            'method'=>$request->method(), //retorna el metodo http que uso el cliente 
            'headers'=> $request->headers->all(), //Devuelve todos los headers de la peticion
            'body'=>$request->getContent() //obtiene el cuerpo crudo de la peticion
        ];
        
        //dd($data);
        Log::info("solicitud Recibida: ", $data);
        return $next($request);
    }
    //terminate se ejecuta despues de que la respuesta ha sido enviada al cliente
    public function terminate(Request $request, Response $response){
        Log::info("Respuesta enviada",[
            "status"=>$response->getStatusCode(), //regresa el tipo de estatus http
            "content"=>$response->getContent() //regresa el contenido de la respuesta
        ]);
    }
}
