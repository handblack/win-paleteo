<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function login_submit(Request $request){
        $request->validate([
            'email'     => 'required',
            'password'  => 'required',
        ]);
        $credentials = [
            'email'     => $request->email,
            'password'  => $request->password,
            'isactive'  => 'Y',
        ];
        if (Auth::attempt($credentials)){
            return redirect()->intended('dashboard');
        }
        return back()->withErrors(['error' => 'Error en credenciales.']);
    }

    public function dashboard(){
        return view('dashboard.index');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('home');
    }

    function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return the server IP if the client IP is not found using this method.
    }

    public function building(){
        return view('building');
    }
}
