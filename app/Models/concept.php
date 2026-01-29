<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class concept extends Model
{
    protected $table = 'concept'; 

    //fillable sirve para asignar masivamente 
    protected $fillable = ['quantity', 'price', 'product_id', 'sale_id'];

    //metodo para la relacion con la tabla sale
    public function sale(){
        return $this->belongsTo(sale::class);
    }
}
