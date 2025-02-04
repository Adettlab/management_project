<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', ["title" => "Login"]);
    }

    public function authenticate(Request $request)
    {
        $validatedata = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($validatedata)) {
            $request->session()->regenerate();


            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'login' => 'login gagal',
        ])->withInput();
    }

    public function logout(request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }
}

