@extends('plantillas.inicio')

@section('titulo', 'Editar Usuario')

@section('h1', 'Editar Usuario')

@section('contenido')
<div class="form-box">
    <h2>Editar Usuario</h2>

    <form action="{{ route('actualizarUsuario', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $usuario->nombre) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $usuario->correo) }}" required>
        </div>


        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Confirmar Cambios</button>
            <a href="{{ route('mostrarDatosDeTodosLosUsuarios') }}" class="btn btn-cerrar">Cancelar</a>
        </div>
    </form>
</div>
@endsection
