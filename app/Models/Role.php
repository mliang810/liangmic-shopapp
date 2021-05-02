<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name']; //these are the columns we're allowing for mass assignment -- must speicify for security reasons

    public static function getUser(){
        return self::where('slug', '=', 'shopper')->first(); //Role::where('slug', '=', 'user')->first();
    }
    public static function getOwner(){
        return self::where('slug', '=', 'shopOwner')->first(); //Role::where('slug', '=', 'user')->first();
    }
}
