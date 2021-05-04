<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class userAbility
{
    use HandlesAuthorization;
    public function owner(User $user){ //can only edit shop if you even have one -- rule will apply to ALL database changes. also applies to creating products.
        return $user->isOwner()
            ? Response::allow()
            : Response::deny('You do not own this/a shop.');
    }

    public function editMyShop(User $user, Shop $shop){ //toggle on --> edit store button is available 
        if($user->shop !==null){
            return $user->shop->id === $shop->id;
        }
        return false;
    }

    public function editOn(User $user){ //edit buttons beyond just the toggle edit on button is available
        if($user->shop !==null){
            return $user->shop->edit_mode===1;
        }
        return false;
    }

    public function makeShop(User $user){ //can make a shop if you don't already have one
        return $user->notOwner()
            ? Response::allow()
            : Response::deny('You already have a shop.');
    }

    public function editAct(){ //edit account info and bookmarks
        return Auth::check();
    }

    public function editProduct(User $user, Product $product){
        return $product->user_id === $user->id
            ? Response::allow()
            : Response::deny('Cannot edit a product listing that you do not own.');
    }

}
