<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class RecuperaPassword extends Controller {
    public function mostraFormularioPedido() {
        return view('auth.envia-recuperacao');
    }

    public function mostraFormularioRecuperacao($token) {
        return view('auth.altera-password', [
            'token' => $token
        ]);
    }

    public function submetePedido(Request $request) {
        $request->validate(['e_mail' => 'required|e_mail']);
        $status = Password::sendResetLink(
            $request->only('e_mail')
        );
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['e_mail' => __($status)]);
    }

    public function alteraPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'e_mail' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('e_mail', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'palavra_passe' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['e_mail' => [__($status)]]);
    }
}
