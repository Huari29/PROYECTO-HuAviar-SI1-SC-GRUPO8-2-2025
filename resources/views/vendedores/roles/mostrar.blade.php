@extends('plantillas.inicio')
@section('h1','Roles')

@section('contenido')
<div class="container">
    <h2>Lista de Roles</h2>
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($roles as $rol)
            <tr>
                <td>{{ $rol->id }}</td>
                <td>{{ $rol->descripcion }}</td>
                <td>
                    <div class="div-botones">
                        <a href="{{ route('rols.edit',$rol->id) }}" class="btn-editar">Editar</a>
                        <form action="{{ route('rols.destroy',$rol->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar"
                                onclick="return confirm('¿Eliminar este rol?')">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="div-botones2">
        <a href="{{ route('rols.create') }}" class="btn-editar">Nuevo Rol</a>
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
