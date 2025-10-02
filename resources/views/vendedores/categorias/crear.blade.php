@extends('plantillas.inicio')
@section('h1','Nueva Categoría')

@section('contenido')
<div class="form-box">
    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" required>
        </div>
        <div class="form-group">
            <label>Descripción</label>
            <textarea id="descripcion" name="descripcion" class="textarea-controlado"></textarea>
        </div>
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Guardar</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
