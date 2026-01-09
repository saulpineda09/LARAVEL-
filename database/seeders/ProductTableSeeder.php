<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker; 


class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker=  Faker::create();//objeto de la clase factory 
        
        
        //pluck regresa un array de valores 
        $categoryIds= DB::table('category')->pluck("id")->toArray();  //guarda los id de la tabla category

        if(empty($categoryIds)){ //verifica si hay categorias en la tabla 
            $this->command->warn("no hay categorias en la tabla category"); 
            return;
        }
        $products = []; //Se inicializa un array vacio que va guardar los productos 

        //rellena el arreglo para la tabla product de la bd
        for($i=1; $i<=50; $i++){
            $products[]=[
                'name' => $faker->word,
                'description'=> $faker->sentence,
                'price'=> $faker->randomFloat(2,10,500), //rand genera un numero aleatorio

                //como tenemos una fk en product llamada category_id, le asignamos un valor aleatorio
                'category_id'=> $faker->randomElement($categoryIds), //randomElement recibe un valor array
                'created_at'=>now(),
                'updated_at'=>now(),
            ];
        }
        //insert todos los registros del arreglo products a la tabla product de la BD
        DB::table('product')->insert($products); 
    }
}
