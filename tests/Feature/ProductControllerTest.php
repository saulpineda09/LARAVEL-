<?php
//se modidfica el archivo Pest.php para agregar el trait RefreshDatabase
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

beforeEach(function(){
    //codigo que se ejecuta antes de cada test 
    $this->withoutMiddleware(\Tymon\JWTAuth\Http\Middleware\Authenticate::class); 
});

test('example', function () {
//aqui primero creamos un usuario y obtenemos el token (solo si tenemos la ruta protegida con middleware)
    $user = User::factory()->create();
    $token = JWTAuth::fromuser($user);
    
    Product::factory()->count(15)->create();
    $response = $this->withHeader("Authorization", "Bearer $token")-> //esto agrega el token a la peticion
    getJson('/api/product?per_page=5&page=0');

    $response
        ->assertStatus(Response::HTTP_OK) //O 200
        ->assertJsonCount(5, 'data')->assertJsonStructure([  //valida solo la estructura
           'data' => [
                '*' => ['id', 'name', 'description', 'category_id']
            ]
        ]);
    
    $data = $response->json('data');
    expect(count($data))->toBe(5);
});



test("crear un producto de manera correcta", function(){
    $category= Category::factory()->create(); 

    $productData=[
        "name"=>"Producto de prueba",
        "description"=>"Descripcion del producto de prueba",
        "price"=>100.50,
        "category_id"=>$category->id
    ];
    $response = $this->postJson(route('product.store'), $productData); 
    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson(['data'=>$productData]); //valida los valores y la estrucura 
        //se pone data porque asi se estructura la respuesta en el controlador 
        //ej: es return response()->json(["mensaje"=>"objeto creado con exito","data"=>$product],201 );
        //su estrucutra es un array con mensaje y data 
        //´data´{...} contiene el producto creado

    $this->assertDatabaseHas('product', $productData); 
}); 

test("Datos de productos invalidos al mandarse a crear", function(){
    $invalidProductData= [
        "name"=>"", //nombre vacio
        "description"=>str_repeat("a", 3000), //descripcion muy larga
        "price"=> "texto en vez de numero", //precio invalido
        "category_id"=>9999 //categoria que no existe
    ]; 

    $response = $this->postJson(route('product.store'), $invalidProductData);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
    ->assertJsonValidationErrors(['name', 'description', 'price', 'category_id']);
    //este metodo busca en la respuesta la palabra errors y valida que existan los errores de validacion 
    //la palabra errors debe venir en el controlador en el return de la excepcion de la validacion 
}); 

test("actualizar un producto", function(){
    $category = Category::factory()->create(); 

    $product = Product::factory()->create([
        'category_id'=>$category->id  //los demas campos del producto se generan automaticamente menos category_id
    ]);
    $newCategory = Category::factory()->create();

    $data = [
        "name"=>"Nombre actualizado",
        "description"=>"Descripcion actualizada",
        "price"=>250.75,
        "category_id"=>$newCategory->id
    ]; 

    $response = $this->putJson(route('product.update', $product), $data) //putjson es para enviar datos en formato json 
    ->assertJson([ //este metodo valida la estructura y valores 
        "message"=>"producto actualizado exitosamente",
        "product"=>[
            'id'=>$product->id,
            "name"=>"Nombre actualizado",
            "description"=>"Descripcion actualizada",
            "price"=>250.75,
            "category_id"=>$newCategory->id
        ]

    ]);
      $this->assertDatabaseHas("product", [ //este metodo es para validar si existe en la bd 
        'id'=>$product->id,
        "name"=>"Nombre actualizado",
        "description"=>"Descripcion actualizada",
        "price"=>250.75,
        "category_id"=>$newCategory->id
      ]);
});

test("falla si no se envia la categoria", function (){
    $category = Category::factory ()->create(); 
    $product = Product::factory()->create([
        'category_id'=>$category->id  //los demas campos del producto se generan automaticamente menos category_id
    ]); 

    $data = [ //la data siempre se obtiene de la peticion que vamos a testear, en este caso del update
               //por si no se envia category_id
        "name"=>"Nombre actualizado",
        "description"=>"Descripcion actualizada",
        "price"=>250.75
        //no se envia category_id
    ];

    $response = $this->putJson(route('product.update', $product), $data);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
    ->assertJsonValidationErrors(['category_id']); 

});

test("falla si category_id no existe en la bd", function(){
    $category = Category::factory ()->create(); 
    $product = Product::factory()->create([
        'category_id'=>$category->id  //los demas campos del producto se generan automaticamente menos category_id
    ]); 

    //dd($category->id);//esto es para ver el id de la categoria creada
    $data = [ //la data siempre se obtiene de la peticion que vamos a testear, en este caso del update
               //por si no se envia category_id
        "name"=>"Nombre actualizado",
        "description"=>"Descripcion actualizada",
        "price"=>250.75,
        "category_id"=>9999 //categoria que no existe
    ];

    $response = $this->putJson(route('product.update', $product), $data);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
    ->assertJsonValidationErrors(['category_id']);
});

test("Elimina un producto correctamente", function(){
    $product = Product::factory()->create();

    $response = $this->deleteJson(route('product.destroy', $product));
    $response->assertStatus(Response::HTTP_OK)
    ->assertJson([
        "message"=>"Producto eliminado"
    ]);

   // $assertDatabaseMissing('product', ['id'=>$product->id]);
    $this->assertSoftDeleted('product', ['id'=>$product->id]); //ESTE METODO ES PARA ELIMINAR EL BORRADO LOGICO EN LA BD
});

test("Elimina un producto que no existe", function(){
    $response = $this->deleteJson(route('product.destroy', ['product'=>9999])); //id que no existe
    $response->assertStatus(Response::HTTP_NOT_FOUND);

});