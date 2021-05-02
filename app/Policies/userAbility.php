<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class userAbility
{
    use HandlesAuthorization;
    public function editShop(User $user){ //can only edit shop if you even have one -- rule will apply to ALL database changes.
        return $user->isOwner()
            ? Response::allow()
            : Response::deny('You do not own this shop.');
    }

    public function makeShop(User $user){ //can make a shop if you don't already have one
        return $user->notOwner()
            ? Response::allow()
            : Response::deny('You already have a shop.');
    }

    public function editAct(){ //edit account info and bookmarks
        return Auth::check();
    }

}
