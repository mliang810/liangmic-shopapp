<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_content extends Model
{
    use HasFactory;

    public function invoice_products(){
        $this->hasMany(Product::class);
    }
}
