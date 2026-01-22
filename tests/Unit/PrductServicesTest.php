<?php

use App\Business\Entities\Taxes;
use App\Business\Services\ProductServices;
use LDAP\Result;

test('Calcula el impuesto del iva', function () {
    $price = 100;
    
    $service = new ProductServices(); 
    $result = $service->calculateIva($price); 
    expect($result)->toBe($price * (1 +Taxes::IVA)); 
});
