<h1>Perfil de {{ $usuario->nombre }}</h1>
<p>ID: {{ $usuario->id }}</p>
<p>Email: {{ $usuario->email }}</p>
<form method="GET" action="{{ route('inicio') }}">
    <button type="submit" class="btn">regresar</button>
</form>
