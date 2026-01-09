<?php 

namespace App\Business\Services; 

class SingletonServices{

    public $value;

    public function __construct()
    {
        $this->value= rand(1,1000); 
    }
}