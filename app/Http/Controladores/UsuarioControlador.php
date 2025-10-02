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
    public function editarUsuario($id)
    {
        $usuario = Usuario::obtenerUsuario($id);
        return view('vendedores.editar-usuario', compact('usuario'));
    }
    public function actualizarUsuario(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo,' . $id,
        ]);

        $usuario = Usuario::findOrFail($id);
        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->save();

        return redirect()->route('mostrarDatosDeTodosLosUsuarios')->with('success', 'Usuario actualizado correctamente.');
    }

public function eliminarUsuario($id)
{
    $usuario = Usuario::findOrFail($id);
    $usuario->delete();

    return redirect()->route('mostrarDatosDeTodosLosUsuarios')->with('success', 'Usuario eliminado correctamente.');
}
}
