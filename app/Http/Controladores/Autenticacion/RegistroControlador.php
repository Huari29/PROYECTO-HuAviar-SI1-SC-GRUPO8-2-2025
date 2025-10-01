<?php

namespace App\Http\Controladores\Autenticacion;

use App\Http\Controladores\Controlador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistroControlador extends Controlador
{
    // Mostrar formulario
    public function mostrarFormularioDeRegistro()
    {
        return view('autenticacion.registro');
    }

    // Procesar registro
    public function registrar(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:150'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','confirmed','min:6'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user); // iniciar sesión automáticamente
        return redirect('/');
    }
}
