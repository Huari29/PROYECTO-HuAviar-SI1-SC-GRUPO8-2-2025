<?php

namespace App\Http\Controladores\Autenticacion;

use App\Http\Controladores\Controlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RestablecerContraseniaControlador extends Controlador
{
    // Mostrar formulario con el token
    public function mostrarFormularioDeReinicio(Request $request, $token = null)
    {
        return view('atenticacion.reinicio-de-contrasenia', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // Guardar nueva contraseña
    public function guardarNuevaContrasenia(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('acceso')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
