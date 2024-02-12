<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Auth;

class cek_login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$levels): Response
    {
        if(Auth::user()){
            if(in_array(Auth::user()->level, $levels)){
                return $next($request);
            } else {
                return redirect()->route('login')->with(['error'=>'Anda tidak memiliki hak akses untuk memasuki halaman ini']);
            }
        }
        return redirect()->route('login')->with(['error'=>'Anda tidak bisa masuk tanpa login']);
    }
}
