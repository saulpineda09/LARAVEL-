<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //usa DB:table para insertar directamente los datos en la tabla 'category'
        DB::table('category')->insert([ 
            [
                'name'=>'comida'
            ],
            [
                'name'=>'bebida'
            ],
            [
                'name'=>'Alcohol'
            ],
            ]);
    }
}
