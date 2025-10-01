<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @guest
            @yield('titulo', 'HuAviar')
        @else   
            @yield('titulo', 'Bienvenido')    
        @endguest
    </title>
    <link rel="icon" type="image/png" href="{{ asset('imagenes/logo2.png')}}" sizes="32x32">
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: #f7f7f7;
        color: #333;
    }
    header {
        background: #ef8504;
        color: white;
        padding: 20px 20px;
        text-align: center;
        display: flex;
        justify-content: space-between; /* título a la izquierda, botones a la derecha */
        align-items: center;
    }
    header h1 {
        margin: 0;
        font-size: 2em;
    }
    .header-buttons {
        display: flex;
        gap: 15px;
    }
    .header-buttons a,
    .header-buttons button {
        color: #ef8504;
        background: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s, color 0.3s;
        border: none;
        cursor: pointer;
    }
    .header-buttons a:hover,
    .header-buttons button:hover {
        background: #a75407;
        color: white;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 30px auto;
    }
    .category {
        margin-bottom: 50px;
    }
    .category h2 {
        border-bottom: 2px solid #ef8504;
        padding-bottom: 10px;
        color: #ef8504;
    }
    .bird-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .bird-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .bird-card:hover {
        transform: scale(1.05);
    }
    .bird-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    .bird-card .info {
        padding: 15px;
    }
    .bird-card .info h3 {
        margin: 0 0 10px 0;
        font-size: 1.2em;
    }
    .bird-card .info p {
        margin: 0;
        font-size: 0.95em;
        color: #666;
    }

    /* Formularios */
    .form-box {
        width: 90%;
        max-width: 400px;
        margin: 50px auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
        color: #ef8504;
        text-align: center;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
    }
    input:focus {
        border-color: #ef8504;
    }
    .btn {
        width: 100%;
        background: #ef8504;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 5px;
        font-size: 1em;
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn:hover {
        background: #a75407;
    }
    .extra-links {
        text-align: center;
        margin-top: 15px;
    }
    .extra-links a {
        color: #ef8504;
        text-decoration: none;
    }
    .extra-links a:hover {
        text-decoration: underline;
    }

    footer {
        background: #333;
        color: white;
        text-align: center;
        padding: 20px 0;
        margin-top: 50px;
    }
</style>

</head>

<body>

    <header>
        <h1>@yield('h1', 'Bienvenido')</h1>

        <nav style="display:flex; justify-content:flex-end; align-items:center; gap:15px;">
    @guest
        @yield('botones')
    @else
        <div style="position:relative; display:inline-block;">
            <button id="userMenuBtn" style="color:#ef8504; background:white; padding:8px 15px; border-radius:5px; font-weight:bold; border:none; cursor:pointer;">
                {{ Auth::user()->nombre ?? Auth::user()->email }} ▼
            </button>

            <ul id="userMenu" style="
                display:none;
                position:absolute;
                right:0;
                background:white;
                color:#333;
                list-style:none;
                padding:0;
                margin:0;
                border-radius:5px;
                box-shadow:0 2px 10px rgba(0,0,0,0.1);
                min-width:150px;
                z-index:1000;">
                <li style="border-bottom:1px solid #eee;">
                    <a href="{{ route('perfil') }}" style="display:block; padding:10px; text-decoration:none; color:#333;">Perfil</a>
                </li>
                <li>
                    <form method="POST" action="{{ route('cerrarSesion') }}">
                        @csrf
                        <button type="submit" style="width:100%; text-align:left; padding:10px; border:none; background:none; cursor:pointer; color:#333;">Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const boton = document.getElementById('userMenuBtn');
                const menu = document.getElementById('userMenu');

                boton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
                });

                document.addEventListener('click', function() {
                    menu.style.display = 'none';
                });
            });
        </script>
    @endguest
</nav>

    </header>

    @yield('content')
</body>
<footer>
        <p>© {{ date('Y') }} Tu Empresa | Contacto: info@tudominio.com</p>
</footer>
</html>
