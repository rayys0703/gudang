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
        if (Session::has('token')) {
            return $next($request);
        }

        return redirect()->route('showLoginForm')->withErrors('Anda harus login terlebih dahulu.');
    }
}
