<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        // dd($request);
        $credentials = $request->validateWithBag('login', [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return back();
        }

        return back()->withErrors('Username atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function register(Request $request)
    {
        $credentials = $request->validateWithBag(
            'register',
            [
                'nickname' => 'required|min:3|max:20',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password'
            ],
            [
                'nickname.required' => 'Nickname harus diisi',
                'nickname.min' => 'Nickname harus memiliki minimal 3 karakter',
                'nickname.max' => 'Nickname harus memiliki maksimal 20 karakter',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email harus valid',
                'email.unique' => 'Email telah terdaftar',
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password harus memiliki minimal 6 karakter',
                'confirm_password.required' => 'Konfirmasi Password harus diisi',
                'confirm_password.same' => 'Konfirmasi Password harus sama'
            ]
        );

        $credentials['slug'] = strstr($credentials['email'], '@', true);

        User::create($credentials);

        return redirect()->route('home')->with('success', 'Sukses daftar akun, silahkan login dengan akun anda');
    }
}
