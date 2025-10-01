@extends('plantillas.autenticacion')

@section('titulo', 'Iniciar Sesión')

@section('h2','Iniciar Sesión')

@section('contenido')
<form method="POST" action="{{ route('validarAcceso') }}">
        @csrf

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <p style="color:red; font-size: 0.9em;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <p style="color:red; font-size: 0.9em;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn">Entrar</button>
    </form>

    <div class="extra-links">
        <p><a href="{{ route('recuperar.contrasenia') }}">¿Olvidaste tu contraseña?</a></p>
        <p>¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate aquí</a></p>
    </div>
@endsection
