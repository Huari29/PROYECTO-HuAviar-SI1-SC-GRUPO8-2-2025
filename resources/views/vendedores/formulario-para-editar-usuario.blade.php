@extends('plantillas.inicio')

@section('contenido')
<h2>Editar Usuario</h2>

<form method="POST" action="{{ route('actualizar.usuario', $usuario->id) }}">
    @csrf
    @method('PUT')

    <label>Nombre</label>
    <input type="text" name="nombre" value="{{ $usuario->nombre }}" required>

    <label>Correo</label>
    <input type="email" name="correo" value="{{ $usuario->correo }}" required>

    <button type="submit">Actualizar</button>
</form>
@endsection
