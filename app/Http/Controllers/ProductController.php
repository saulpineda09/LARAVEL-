<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;//importacion para validaciones  
use Symfony\Component\HttpFoundation\Response;

use function Laravel\Prompts\error;

class ProductController extends Controller
{
    //funcion index que corresponde al metodo get u obtener la informacion
    //  http://localhost:8080/api/product?per_page=10&page=1
    public function index(Request $request){ 
        $perpage= $request->query("per_page",10); //paginacion, siempre 10 registros por pagina
        $products= Product::paginate($perpage);
        return response()->json($products); 
    }

    //metodo POST con validacion para insertar datos 
    public function store(Request $request ){
        try{
            $validatedData= $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:2000', 
                'price'=> 'required|numeric',
                'category_id'=>'required|exists:category,id'
            ],
            [
                // name
                'name.required' => 'El nombre del producto es obligatorio',
                'name.string' => 'El nombre del producto debe ser un texto válido',
                'name.max' => 'El nombre del producto no debe superar los 255 caracteres',

                // description
                'description.required' => 'La descripción es obligatoria',
                'description.string' => 'La descripción debe ser un texto válido',
                'description.max' => 'La descripción no debe superar los 2000 caracteres',

                // price
                'price.required' => 'El precio es obligatorio',
                'price.numeric' => 'El precio debe ser un número válido',

                // category_id
                'category_id.required' => 'La categoría es obligatoria',
                'category_id.exists' => 'La categoría seleccionada no existe en el sistema'


            ]
        ); 
            //metodo de validacion 
            $product = Product::create($validatedData);  //metodo create para insertar en la bd
            return response()->json(["mensaje"=>"objeto creado con exito","data"=>$product],201 ); 
        //mensaje de error sino esta validado 
        }catch(ValidationException $e){
          return response()->json(["errors"=> $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    
      //METODO UPDATE  PUT con validacion FormRequest
    public function update(UpdateProductRequest $request, Product $product){
        try{
        $validatedData= $request->validated(); //validacion en la clase UpdateProductRequest
        $product->update($validatedData);

        return response()->json(["message"=> "producto actualizado exitosamente", "product"=>$product], Response::HTTP_OK);
        }catch(Exception $e){
            return response()->json(["error"=> $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }    
    }

    //metodo destroy  DELETE 
    // http://localhost:8080/api/product/1
    public function destroy(Product $product){
        $product ->delete(); 
        return response()->json(["message"=>"Producto eliminado"]); 
    }
} 
