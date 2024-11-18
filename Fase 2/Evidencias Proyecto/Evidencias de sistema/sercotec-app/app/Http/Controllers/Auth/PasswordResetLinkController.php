<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('/olvide');
    }

    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Intenta enviar el enlace de restablecimiento de contraseña.
        $status = Password::sendResetLink($request->only('email'));

        // Redirigir con el estado del envío.
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
}
