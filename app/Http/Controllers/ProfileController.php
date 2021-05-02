<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        //MIDDLEWARE -- functions that run before our route
        // use middleware to see if the user is even logged in to access profile page
        return view('auth.profile', [
            'user'=>Auth::user(),
        ]);
    }
    
}
