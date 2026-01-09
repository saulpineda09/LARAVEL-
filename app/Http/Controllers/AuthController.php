<?php

namespace App\Http\Controllers;

use App\Events\UserRegister;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    //metodo post para registar usuario 
    public function register(UserRequest $request)
{
    $validateData= $request->validated(); 
    $user = User::create([
       'name'=>$validateData['name'], 
       'email'=> $validateData['email'], 
       'password'=> bcrypt($validateData['password'])
    ]);

    event(new UserRegister($user)); //disparamos el evento de registro de usuario
    return response()->json(["message"=>"Usuario registrado correctamente", "users"=>$user], Response::HTTP_CREATED); //metodo http o poner 201
   }

   //metodo post para logearse
   public function login(LoginRequest $request){
        $validateData = $request->validated(); 

        //array de credenciales 
        //las credenciales son el email y la password
        $credentials = [
            'email'=>$validateData['email'],
            'password'=>$validateData['password']
        ]; 
        try{
            //aqui hacemos el logeo 
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(["error"=>"usuario o contraseña invalida"], Response::HTTP_UNAUTHORIZED); 
            }

        }catch(JWTException){
            return response()->json(["errror"=>"No se pudo crear el token"], Response::HTTP_INTERNAL_SERVER_ERROR); //o mandar un mensaje 500

        }
        return $this->respondWithToken($token); 
   }


   //este metodo es para obtener el usuasrio autenticado 
   public function who(){
    $user = auth()->user(); 
    return response()->json(["user"=>$user], Response::HTTP_OK); 
   }

   public function logout(){
    try{
        $token= JWTAuth::getToken(); 
        JWTAuth::invalidate($token);
        return response()->json(["message"=>"Sesion cerrada correctamente"], Response::HTTP_OK); 
    }catch(JWTException $e){
        return response()->json(["error"=>"No se pudo cerrar la sesion el token no es valido"], Response::HTTP_INTERNAL_SERVER_ERROR); 
    }
   }

   //metodo para refrescar el token
   public function refresh(){
    try{
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh(); //creamos un nuevo token 
        JWTAuth::invalidate($token); //invalidamos el token viejo
        return $this->respondWithToken($newToken); //devolvemos el nuevo token 
    }catch(JWTException $e){
        return response()->json(["error"=>"No se pudo refrescar el token". $e], Response::HTTP_INTERNAL_SERVER_ERROR); 
    }
   }

     //este metodo es para devolver el token, el tipo de token y el tiempo de expiracion
   protected function respondWithToken($token){
    return response()->json([
        "token"=>$token, 
        "token_type"=>"bearer", 
        "expires_in"=>auth()->factory()->getTTL() //tiempo de expiracion del token en minutos
    ]); 
   }
}
