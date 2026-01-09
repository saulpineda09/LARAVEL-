<?php 

namespace App\Business\Services;

use App\Models\User;

class UserService{

    public function __construct(protected EncryptService $encryptorService)
    {
        
    }

    //metodo para encriptar el email de un usuario obteniendo primero el id del usuario 
    public function encryptEmail(int $id):string{
        $user = User::find($id); 
        return $this->encryptorService->encrypt($user->email); 
  }
}