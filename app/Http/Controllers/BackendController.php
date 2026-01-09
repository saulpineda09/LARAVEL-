<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response; 



class BackendController extends Controller
{
    private $names = [
        1=> ['names'=> 'Ana', 'age'=>30],
        2=> ['names'=> 'itzel', 'age'=>21],
        3=> ['names'=> 'saul', 'age'=>20],
    ]; 

    public function getAll(){ //obtener todo 
        return response()->json($this -> names); 
    }
    
    public function get($id =0){ //atributo id que se pasa en el endopoint, sino le mandamos el valor por default id=0
        if(isset($this->names[$id])){ //si existe el id 
            return response()->json($this->names[$id]); //manda una respuesta 200
        }
        return response()->json(["error" => "nombre no existenete"], Response::HTTP_NOT_FOUND); 
    }

    public function create(Request $request){ //decirle a chat gpt que me explique este metodo es un metodo para post 

        $person=[
            "id"=> count($this->names) +1 , 
            "name"=>$request->input("name"), 
            "edad"=> $request->input("age")
        ]; 
        $this->names[$person["id"]]= $person; 
        return response()->json(["mensaje: " => "persona creada", "person"=>$person], Response::HTTP_CREATED);  

    }

    public function update(Request $request, $id){ //funcion put actualizar, preguntarle a chat metodo put
        if(isset($this->names[$id])){
            $this->names[$id]["names"]= $request ->input("names") ;
            $this->names[$id]["age"]= $request ->input("age") ; 
            
            return response()->json(["mensaje: ", "Persona actualizada correctamente","person"=> $this->names[$id]]); 

        }
        return response()->json(["error: "=> "Persona no existente"], Response::HTTP_NOT_FOUND); 
    }

    public function delete(int $id){
        if(isset($this->names[$id])){
            unset($this->names[$id]); 

            return response()->json(["mensaje: "=> "persona eliminada"],Response::HTTP_OK); 
        }
        return response()->json(["error: "=> "Persona no existe"], Response::HTTP_NOT_FOUND); 

    }
}
