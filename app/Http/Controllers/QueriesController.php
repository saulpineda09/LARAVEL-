<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class QueriesController extends Controller
{
    //METODO QUE OBTIENE TODOS LOS REGISTROS
    public function get(){
        //devuelve todos los valores de product en un json 
        $product = Product::all();//Guarda toda la info de la tabla product en la variable product 
        return response()->json($product); 
    }

    //METODO QUE OBTIENE POR ID INDIVIDUAL 
    public function getById(int $id){
        $product= Product::find($id); 

        if(!$product){
            return response()->json(["mensaje" => "producto no encontrado"], Response::HTTP_NOT_FOUND);
        }
        return response()->json($product);
    }

    //METODO QUE OBTIENE TODOS LOS NOMBRES 
    public function getNames(){
        $products = Product::select("name")->orderBy("name", "desc")->get();
        return response()->json($products); 
    }

    //METODO DE BUSQUEDA POR NOMBRE Y PRECIO
    public function searchNames(string $name, float $price){
        $product = Product::where("name", $name)->where("price", ">",$price) //paso el nombre del producto y el precio
        ->orderBy("name") //ordenar por nombre ascendente
        ->select("name", "description") //solo muestra el nombre y la description 
        ->get(); //lo obtiene 

        return response()->json($product);
    }

    //METODO DE BUSQUEDA EN LA DESCRIPCION O EL NOMBRE 
    public function searchString(string $value){
        $product= Product::where("description", "like", "%{$value}%") //metodo de busqueda por descripcion 
        ->orWhere("name", "like", "%{$value}%")  //o por nombre, mientras exista la palabra que se la pase a la url
        ->get(); //obtiene

        return response()->json($product);
    }


    //METODO DE BUSQUEDA AVANZADA 
    public function advancedSearch(Request $request){ 
        $product= Product::where(function($query) use($request){ //busqueda avanzada, osea busqueda por lo que sea que le pasemos en la tabla product
            if($request->input("name")){
                $query->where("name","like", "%{$request->input("name")}%");
            }
        })
        ->where(function($query) use($request){ //busqueda avanzada, osea busqueda por lo que sea que le pasemos en la tabla product
            if($request->input("description")){
                $query->where("description","like", "%{$request->input("description")}%");
            }
        })
        ->where(function($query) use($request){ //busqueda avanzada, osea busqueda por lo que sea que le pasemos en la tabla product
            if($request->input("price")){
                $query->where("price",">", $request->input("price"));
            }
        })

        ->get();
        return response()->json($product);
    }

    //metodo por join 
    public function join(){
        $product = Product::join("category", "product.category_id", "=", "category_id")
        ->select("product.*", "category.name as category")
        ->get();
        return response()->json($product);
    }

    //METODO GROUPBY
    public function groupBy(){
        $result = Product::join("category", "product.category_id", "=", "category_id")
        ->select("category.id", "category.name", DB::raw("COUNT(product.id) as total"))
        ->groupBy("category.id", "category.name")
        ->get();

        return response()->json($result);

    }
}
