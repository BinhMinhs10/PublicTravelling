<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Validator;
class LoginController extends Controller
{
    public function doLogin(Request $request){
    	
        $data=[
            'username'=>$request->username,
            'password'=>$request->password,
        ];

        if(Auth::attempt($data)){
            return redirect('home')->with('success','You are successfully logged in');
        }else{
            return redirect('login')->with('fail', 'You have entered an invalid username or password');
        }
    }
    public function login(){
    	return view('auth/login');
    }
    public function signup(){
    	return view('auth/register');
    }
}
