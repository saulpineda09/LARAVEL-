<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 


class Category extends Model
{

    use HasFactory; 
    
    protected $table = 'category'; 
    protected $fillable =['name'];
    
    public function product(){
        //asi laravel sabe que tengo una llave foranea en product 
        return $this->hasMany(Product::class);//hasMany indica que una categoria puede tener muchos productos 
    }
}
