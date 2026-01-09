<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpperCaseName
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->has("name")){ //revisa si existe el campo name 
            $request->merge([  //merge reemplaza o agrega elementos de la solicitud 
                "name" => strtoupper($request->input("name")) //strtoupper convierte en mayusculas el texto 
            ]);
        }

        return $next($request);
    }
}
