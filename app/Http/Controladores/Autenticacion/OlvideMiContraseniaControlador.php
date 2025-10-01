<?php

namespace App\Http\Controladores\Autenticacion;

use App\Http\Controladores\Controlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class OlvideMiContraseniaControlador extends Controlador
{
    // Mostrar formulario
    public function mostrarFormularioDeSolicitudDeEnlace()
    {
        return view('autenticacion.recuperacion-de-contrasenia');
    }

    // Enviar email con enlace
    public function enviarEnlaceDeRestablecerCorreoElectronico(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT ? back()->with(['status' => __($status)]) : back()->withErrors(['email' => __($status)]);
    }
}
