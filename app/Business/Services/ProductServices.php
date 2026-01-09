<?php 

namespace App\Business\Services;

use App\Business\Entities\Taxes;

class ProductServices{
    public function calculateIva($price){
        return $price * (1 + Taxes::IVA);  
    }
}