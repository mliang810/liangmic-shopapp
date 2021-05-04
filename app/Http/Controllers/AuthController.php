<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $loginSuccessful = Auth::attempt([ //will return true or false 
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if($loginSuccessful){
            return redirect()->route('home');
        }
        else{
            return redirect()->route('auth.index')->with('error', 'Invalid credentials');
        }
    }

    public function logout(){
        Auth::logout(); 
        return redirect()->route('home');
    }
}
