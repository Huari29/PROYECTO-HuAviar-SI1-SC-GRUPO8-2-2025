@extends('plantillas.inicio')

@section('contenido')
<div class="container">
    <h2 class="mb-4">Lista de Usuarios</h2>

    {{-- Mensajes de éxito --}}
    @if (session('success'))
        <div style="background: #d4edda; padding: 10px; margin-bottom: 15px; border: 1px solid #c3e6cb; color: #155724;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabla de usuarios --}}
    <div class="category">
        <h2>Usuarios Registrados</h2>

        <div style="overflow-x:auto;">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->correo ?? $usuario->email }}</td>
                            <td>{{ $usuario->rol }}</td>
                            <td>{{ $usuario->direccion }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>
                                <div class="div-botones">
                                    <a href="{{ route('editar.usuario', $usuario->id) }}" class="btn-editar">Editar</a>
        
                                    <form action="{{ route('eliminar.usuario', $usuario->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('¿Seguro que deseas eliminar este usuario?')"
                                            class="btn-eliminar">
                                                Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;">No hay usuarios registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Botón para crear usuario --}}
    <div class="header-buttons" style="display:flex; gap:10px;">
        <a href="{{ route('formularioParaCrearNuevoUsuario') }}" >Crear Usuario</a>
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" >Volver</a>
    </div>

</div>
@endsection
