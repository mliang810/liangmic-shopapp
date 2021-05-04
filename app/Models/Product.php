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

    public function shop_contents(){
        return $this->hasOne(Shop_content::class);
    }

    public function product_image(){
        return $this->product_image;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
