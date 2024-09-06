<?php

// App\Http\Controllers\Auth\RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        //$this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'name.min' => 'Nama minimal harus :min karakter.',
            'email.min' => 'Email minimal harus :min karakter.',
            'password.min' => 'Password minimal harus :min karakter.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Kirim permintaan pendaftaran ke API Laravel A
        $response = Http::api()->post('/register', [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation'),
        ]);

        if ($response->successful()) {
            $loginResponse = Http::api()->post('/login', [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);

            if ($loginResponse->successful()) {
                // Simpan token di session atau cookie
                Session::put('token', $loginResponse['token']);
                Session::put('user', $loginResponse['user']);
                
                return redirect()->route('dashboard');
            }

            return redirect()->back()->withErrors(['email' => 'Gagal login']);
        }

        $errorMessage = 'Gagal daftar akun';
        if ($response->status() === 422) {
            $responseData = $response->json();
            if (isset($responseData['errors'])) {
                $errorMessage = $responseData['errors'];
            }
        }

        return redirect()->back()->withErrors(['email' => $errorMessage]);
    }

}
