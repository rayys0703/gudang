<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     $token = Session::get('token');

    //     if (!$token) {
    //         return redirect()->route('showLoginForm')->withErrors('Anda harus login terlebih dahulu.');
    //     }

    //     return $next($request);
    // }
}
