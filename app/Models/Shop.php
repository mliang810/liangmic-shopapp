<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getId(){
        return $this->id;
    }

    public function shopContents(){
        return $this->hasMany(Shop_content::class);
    }

    public function maintenance(){
        return $this->hasOne(Maintenance::class);
    }
}
