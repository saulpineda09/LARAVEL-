<?php


//esta es la tabla creada en la bd 
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     Laravel siempre ejecuta este metodo 
     */
    public function run(): void
    {

        Category::factory(3)->create()->each(function($category){
            Product::factory(10)->create(["category_id"=>$category->id]);
        });
        /*

        User::factory()->create([ //crea un usuario de prueba usando factory 
            'name'=>'Test User',
            'email'=>'text@example.com'
        ]);

        //SEEDER el metodo call llama a otras clases seeder 
        $this->call([ //esto ejecuta una clase que devuelve un arreglo 
            CategoryTableSeeder::class, //la clase se llama CategoryTableSeedeer
            //para indicar que clase es es necesario escribir ::class
            ProductTableSeeder::class

        ]);
        */
    }
}
