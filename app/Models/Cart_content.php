<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_content extends Model
{   

    use HasFactory;
    public function cart_products(){
        $this->hasMany(Product::class);
    }
}
