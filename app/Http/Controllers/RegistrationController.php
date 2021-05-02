<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function index(){
        return view('auth.register');
    }

    public function register(Request $request){ //submitting user data to the database
        $request->validate([
            'name' => 'required|max:50',
            'password' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users'
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'));
        $user->email = $request->input('email');
        $user->username = $request->input('username');

        $userRole = Role::getUser(); //automatically a normal customer, unless they register a shop, in which case, get switched over to 
        $user->role()->associate($userRole);
        $user->save();

        Auth::login($user);
        return redirect()->route('home');
    }
}
