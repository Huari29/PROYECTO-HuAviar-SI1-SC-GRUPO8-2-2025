<?php

namespace App\Http\Controladores;

use App\Http\Controladores\Controlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Modelos\Usuario;

class UsuarioControlador extends Controlador
{
    public function bienvenido()
    {
        return view('vendedores.bienvenido');
    }
    public function mostrarDatosPersonales()
    {
        return view('vendedores.bienvenido');
    }
    public function mostrarDatosDeTodosLosUsuarios()
    {
        $usuarios = Usuario::obtenerUsuariosCompleto();
        return view('vendedores.mostrar-usuarios', compact('usuarios'));
    }
    public function editar($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('vendedores.formulario-para-editar-usuario', compact('usuario'));
    }
    public function actualizar(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'correo' => 'required|email|unique:usuarios,correo,' . $id,
    ]);

    $usuario = Usuario::findOrFail($id);
    $usuario->nombre = $request->nombre;
    $usuario->correo = $request->correo;
    $usuario->save();

    return redirect()->route('mostrar.usuarios')->with('success', 'Usuario actualizado correctamente.');
}

public function eliminar($id)
{
    $usuario = Usuario::findOrFail($id);
    $usuario->delete();

    return redirect()->route('mostrar.usuarios')->with('success', 'Usuario eliminado correctamente.');
}
}
