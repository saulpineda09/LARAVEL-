<?php 


namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class apiFormRequest extends FormRequest{
     //metodo que valida si no mandan un atributo 
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["message"=>"error de validacion",
        "errors"=>$validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY));
        //La libreria que se importa es la de Response symfoni 
    }
}