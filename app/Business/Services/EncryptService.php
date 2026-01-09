<?php

namespace App\Business\Services;

use Illuminate\Support\Facades\Crypt;

class EncryptService{
    private $key ; 
    public function __construct(string $key){
        $this->key = $key; 
    }

    //metodo que encripta datos a partir de la data recibida como parametro
    public function encrypt(string $data):string{
        return base64_encode($this->key.":".Crypt::encryptString($data)); 
    }

    public function decrypt(string $data):string{
        $decodeData = base64_decode($data);

        //esto se llama desestructuracion de arrays 
        //el primer elemento del array va a ir a la variable $key
        //el segundo elemento del array va a ir a la variable $encrypted
       [$key, $encrypted] = explode(":", $decodeData, 2);

       if($key !== $this->key){
         throw new \Exception("Clave de desencriptacion invalida"); //excepcion por si no funciona
       }
        return Crypt::decryptString($encrypted);
    }

}