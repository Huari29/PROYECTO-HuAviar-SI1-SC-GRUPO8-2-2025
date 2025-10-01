<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HuAviar - Registro</title>
    <link rel="icon" type="image/png" href="{{ asset('imagenes/logo2.png')}}" sizes="32x32">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f7f7f7; color: #333; }
        header { background: #ef8504; color: white; padding: 20px; text-align: center; }
        .container { width: 90%; max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);}
        h2 { color: #ef8504; text-align: center; margin-bottom: 20px;}
        .form-group { margin-bottom: 20px;}
        label { display: block; font-weight: bold; margin-bottom: 5px;}
        input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;}
        input:focus { border-color: #ef8504;}
        .btn { width: 100%; background: #ef8504; color: white; border: none; padding: 12px; border-radius: 5px; font-size: 1em; cursor: pointer; transition: background 0.3s;}
        .btn:hover { background: #a75407;}
        .extra-links { text-align: center; margin-top: 15px;}
        .extra-links a { color: #ef8504; text-decoration: none;}
        .extra-links a:hover { text-decoration: underline;}
        footer { background: #333; color: white; text-align: center; padding: 15px; margin-top: 50px;}
    </style>
</head>
<body>
<header>
    <h1>HuAviar</h1>
</header>

<div class="container">
    <h2>Registrarse</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nombre completo</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name') <p style="color:red;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <p style="color:red;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required>
            @error('password') <p style="color:red;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn">Crear cuenta</button>
    </form>

    <div class="extra-links">
        <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
    </div>
</div>

<footer>
    <p>© {{ date('Y') }} HuAviar | Contacto: info@tudominio.com</p>
</footer>
</body>
</html>
