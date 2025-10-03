<?php

namespace App\Http\Controladores;

use App\Modelos\Rol;
use Illuminate\Http\Request;

class RolControlador extends Controlador
{
    public function index()
    {
        $roles = Rol::all();
        return view('vendedores.roles.mostrar', compact('roles'));
    }

    public function create()
    {
        return view('vendedores.roles.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50',
        ]);

        Rol::create($request->all());
        return redirect()->route('rols.index')->with('success', 'Rol creado correctamente.');
    }

    public function show(Rol $rol)
    {
        return view('vendedores.roles.mostrar', compact('rol'));
    }

    public function edit(Rol $rol)
    {
        return view('vendedores.roles.editar', compact('rol'));
    }

    public function update(Request $request, Rol $rol)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50',
        ]);

        $rol->update($request->all());
        return redirect()->route('rols.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Rol $rol)
    {
        $rol->delete();
        return redirect()->route('rols.index')->with('success', 'Rol eliminado correctamente.');
    }
}
