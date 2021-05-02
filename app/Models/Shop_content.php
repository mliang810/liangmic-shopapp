<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop_content extends Model
{
    use HasFactory;
    public function product(){
        $this->belongsTo(Product::class);
    }
}
