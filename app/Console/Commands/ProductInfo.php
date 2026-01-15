<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ProductInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:product-info {id : Id del producto a consultar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta la informacion de un producto por su id en la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id  = $this->argument("id");
        
        $product = Product::find($id); 


        if(!is_numeric($id  || $id <0)){
            $this->error("Erro: El id debe ser un numero positvo"); 
            return Command::FAILURE;
        }

        if(!$product){
            $this->error("El producto no existe"); 
            return Command::FAILURE; 
        }

        $this->info("Producto encontrado: "); 
        $this->info("nombre: {$product->name}"); 
        $this->info("Descripcion: {$product->description}"); 
        $this->info("Precio: {$product->price}"); 

    }
}
