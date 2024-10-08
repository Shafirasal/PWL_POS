<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        // Jika sudah login, maka redirect ke halaman home
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        // Memeriksa apakah permintaan ini datang dari AJAX atau JSON
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            // Proses login
            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        // Jika bukan dari AJAX, redirect ke halaman login
        return redirect('login');
    }

    public function logout(Request $request)
    {
        // Proses logout
        Auth::logout();

        // Invalidasi dan regenerasi session token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect('login');
    }
}
