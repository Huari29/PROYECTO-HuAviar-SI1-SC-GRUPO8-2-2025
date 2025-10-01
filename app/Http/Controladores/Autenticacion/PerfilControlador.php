<?php

namespace App\Http\Controladores\Autenticacion;

use App\Http\Controladores\Controlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modelos\Usuario;


class PerfilControlador extends Controlador{
    public function verDatos()
    {
        // Obtiene la tupla completa del usuario autenticado
        $usuario = Auth::user();

        // Pasa los datos del usuario a la vista
        return view('autenticacion.perfil', compact('usuario'));
    }
}