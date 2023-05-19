<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // if (time() - $this->session->get('lastActivityTime') > $this->timeout) {
        //     return back()->with('error', 'Sesi anda telah habis!');
        // }

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            if (auth()->user()->stts == 1) {
                $request->session()->regenerate();

                return redirect()->intended('/')->with('message', 'Berhasil masuk sistem');
            } else {
                Auth::logout();
                return back()->with('error', 'User nonaktif!');
            }
        }

        return back()->with('error', 'Login gagal!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('message', 'Berhasil keluar sistem');
    }
}
