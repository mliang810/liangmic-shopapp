<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isOwner(){
        return $this->role->slug === 'shopOwner';
    }

    public function notOwner(){
        return $this->role->slug === 'shopper';
    }

    public function getId(){
        return $this->id;
    }

    public function getShopId(){
        $this->shop->id;
    }

    public function getName() // if you add Attribute to the end of something, laravel will create a proeprty called fullName for us on each instance. so you dont need to say ->getFullName(), you can say ->full_name
    {
        return "{$this->name}";
    }

    public function getUsername(){
        return "{$this->username}";
    }

    public function getEmail(){
        return "{$this->email}";
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function shop(){
        return $this->hasOne(Shop::class);
    }

    public function cart(){
        return $this->hasOne(Cart::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function bookmarks(){
        return $this->hasMany(Bookmark::class);
    }

    public function product(){
        return $this->hasMany(Product::class); //one user can be the creator of many products
    }
}
