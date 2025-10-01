@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

try {
    // Obtener todos los registros de la tabla usuarios
    $usuarios = (DB::SELECT('SELECT * FROM obtener_usuarios_con_su_rol()'));

    // Contar registros
    $totalusuarios = count($usuarios);

    $mensaje = "Conexión exitosa ✅. Hay {$totalusuarios} usuarioses en la tabla.";
} catch (\Exception $e) {
    $mensaje = "Error de conexión o tabla no encontrada ❌: " . $e->getMessage();
    $usuarios = collect(); // colección vacía
    $totalusuarios = 0;
}
@endphp

<h1>{{ $mensaje }}</h1>

@if ($totalusuarios > 0)
    <table border="1" cellpadding="5" cellspacing="0" align="center" >
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>E-mail</th>
                <th>Contraseña</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuarios)
                <tr>
                    <td style="text-align: center;">{{ $usuarios->id }}</td>
                    <td>{{ $usuarios->nombre }}</td>
                    <td>{{ $usuarios->email }}</td>
                    <td>{{ $usuarios->contrasenia }}</td>
                    <td style="text-align: center;">{{ $usuarios->rol }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No hay usuarios para mostrar.</p>
@endif

@php
/*  @for ($i = 0; $i < $totalusuarios; $i++)
        <tr>
            <td>{{ $usuarios[$i]->id }}</td>
            <td>{{ $usuarios[$i]->descripcion }}</td>
        </tr>
    @endfor
*/
@endphp