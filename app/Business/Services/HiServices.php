<?php 

namespace App\Business\Services;

use App\Business\Interfaces\MessageServiceInterface;

class HiServices  implements MessageServiceInterface{
    public function hi(){
        return "Hola mundo desde el servicio HiServices"; 
    }
}