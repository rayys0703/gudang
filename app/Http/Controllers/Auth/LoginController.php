<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $response = Http::api()->post('/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            // Simpan token di session atau cookie
            Session::put('token', $response['token']);
            Session::put('user', $response['user']);
            
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function logout()
    {
        $token = Session::get('token');

        $response = Http::api()->withToken($token)->post('/logout');

        if ($response->successful()) {
            Session::forget(['token', 'user']);
            return redirect()->route('showLoginForm')->with('success', 'Logout berhasil.');
        }

        return redirect()->route('dashboard')->withErrors('Gagal logout.');
    }
}
