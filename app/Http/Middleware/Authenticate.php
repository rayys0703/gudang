<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (Session::has('token') && Session::has('user')) {
            $response = Http::api()->withToken(Session::get('token'))->get('/me');
            
            if ($response->successful()) {
                return $next($request);
            }
            
            Session::flush();
            return redirect()->route('showLoginForm')->withErrors('Sesi Anda telah berakhir. Silakan login kembali.');
        }
        
        Session::flush();
        return redirect()->route('showLoginForm')->withErrors('Anda harus login terlebih dahulu.');
    }
}
