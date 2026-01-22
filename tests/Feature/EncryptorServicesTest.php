<?php

use App\Business\Services\EncryptService;

test('Prueba de encirptador que encripte y sea distinto y desencripte y sea igual', function () {
    $key = "unaclavesecreta"; 

    $encryptor = new EncryptService($key); 
    $OriginalData = "Este es un dato muy importante";

    $encrypterString = $encryptor->encrypt($OriginalData);
    expect($encrypterString)->not->toBe($OriginalData);

    $dencryptedString = $encryptor->decrypt($encrypterString); 
    expect($dencryptedString)->toBe($OriginalData);
});

test("cuando la key sea distinta para desencriptar",function(){
     $key1= "clavesecreta"; 
     $key2= "otraclave";  

     $encryptor1 = new EncryptService($key1); 
     $encryptor2 = new EncryptService($key2);

     $encrypterString = $encryptor1->encrypt("prueba");
     $this->expectException(Exception::class);
     $encryptor2->decrypt($encrypterString);


});