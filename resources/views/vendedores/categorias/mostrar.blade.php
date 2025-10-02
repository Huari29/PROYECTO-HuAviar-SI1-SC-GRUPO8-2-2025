@extends('plantillas.inicio')
@section('h1','Categorías')

@section('contenido')
<div class="container">
    <h2>Lista de Categorías</h2>
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($categorias as $categoria)
            <tr>
                <td>{{ $categoria->id }}</td>
                <td>{{ $categoria->nombre }}</td>
                <td>{{ $categoria->descripcion }}</td>
                <td>
                    <div class="div-botones">
                        <a href="{{ route('categorias.edit',$categoria->id) }}" class="btn-editar">Editar</a>
                        <form action="{{ route('categorias.destroy',$categoria->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar"
                                onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</button>
                        </form>
                        
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="div-botones2">
        <a href="{{ route('categorias.create') }}" class="btn-editar">Nueva Categoría</a>
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
    
</div>
@endsection
