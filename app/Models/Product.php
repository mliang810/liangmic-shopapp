<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function scopePriceAsc($query){
        return $query->orderBy('price', 'ASC');
    }

    public function scopePriceDesc($query){
        return $query->orderBy('price', 'DESC');
    }

    public function tags(){
        return $this->hasMany(Tag::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
