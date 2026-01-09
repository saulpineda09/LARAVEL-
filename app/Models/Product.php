<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes; //treit 

    
    protected $table = 'product'; 
    protected $fillable =['name', 'description', 'price', 'category_id']; 
    
    //todo lo que este en hidden va estar oculto en las solicitudes, 
    //es buena opcion cuando queremos ocultar por ejemplo el password 
    protected $hidden=[
        'created_at', 
        'updated_at'
    ];

    public function category(){ //metodo que indica relacion con la tabla category
        return $this->belongsTo(category::class);
    }
}
