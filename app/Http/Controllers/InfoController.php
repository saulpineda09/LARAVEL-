<?php

namespace App\Http\Controllers;

use App\Business\Interfaces\MessageServiceInterface;
use App\Business\Services\EncryptService;
use App\Business\Services\HiServices;
use App\Business\Services\ProductServices;
use App\Business\Services\SingletonServices;
use App\Business\Services\UserService;
use App\Models\Product;
use Illuminate\Http\Response;

class InfoController extends Controller
{

    public function __construct(private ProductServices $productServices, 
    protected EncryptService $encryptService, protected UserService $userService, 
    protected MessageServiceInterface $hiServices, 
    protected SingletonServices $singletonServices){
    

    }

    public function message(){
        return response()->json($this->hiServices->hi());  //inyeccion de dependencias desde el sericio HiServices 
    }

    public function iva(int $id){
        $product = Product::find($id); 

        if(!$product){
            return response()->json(["message"=>"Prodcuto no encontrado"], Response::HTTP_NOT_FOUND);
        }
        $priceWithIva= $this->productServices->calculateIva($product->price);
        return response()->json(["precio"=>$product->price, "precio con iva"=>$priceWithIva], Response::HTTP_OK);
    }

    public function encrypt($data){
        return response()->json($this->encryptService->encrypt($data));
    }

    public function decrypt($data){
        return response()->json($this->encryptService->decrypt($data));
    }


    public function encryptEmail(int $id):string{
        $emailEncrypted = $this->userService->encryptEmail($id);
        return response()->json(["email_encriptado"=>$emailEncrypted]);
    }

    public function singleton(SingletonServices $singletonServices2){
        return response()->json($this->singletonServices->value." ". $singletonServices2->value);
    }

     public function encryptEmail2(int $id):string{
        $userService = app()->make(UserService::class);
        $emailEncrypted = $userService->encryptEmail($id);
        return response()->json(["email_encriptado"=>$emailEncrypted]);
    }

    
}
