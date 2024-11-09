<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credenciales = $request->validate([

            'email' => ['required', 'email', 'string'],
            'password' => ['required', 'string'],

        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt($credenciales, $remember)) {
            $request->session()->regenerate();

            return redirect()
                ->intended('welcome')
                ->with('success', 'Estas Logeado');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
            'password' => __('auth.password'),
        ]);

    }
    public function logout(Request $request, Redirector $redirector)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerate();

        return $redirector->to('/login')->with('success','Has Cerrado Sesion');

    }
}
