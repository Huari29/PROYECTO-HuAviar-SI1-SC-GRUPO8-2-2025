@extends('plantillas.autenticacion')

@section('titulo', 'Restablecer Contraseña')

@section('h2','Restablecer Contraseña')

@section('contenido')
<form method="POST" action="{{ route('actualizar.contrasenia') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label for="email">Correo electrónico</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <p style="color:red; font-size: 0.9em;">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Nueva contraseña</label>
        <input id="password" type="password" name="password" required>
        @error('password')
            <p style="color:red; font-size: 0.9em;">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirmar contraseña</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>
    </div>

    <button type="submit" class="btn">Restablecer contraseña</button>
</form>

<div class="extra-links">
    <p><a href="{{ route('acceso') }}">Volver al inicio de sesión</a></p>
</div>
@endsection
