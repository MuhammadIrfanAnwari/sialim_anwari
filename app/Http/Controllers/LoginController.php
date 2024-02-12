<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class LoginController extends Controller
{
    public function login(){
        $data['judul'] = 'SIALIM';
        $data['sub_judul'] = 'Login';
        
        return view('login', $data);
    }

    public function post_login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('dashboard');
        }
        return redirect()->route('login')->with(['error'=>'Email/Password anda salah']);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with(['success'=>'Terima Kasih']);
    }
}
