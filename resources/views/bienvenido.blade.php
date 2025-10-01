@extends('plantillas.inicio')

<header>
    @section('h1', 'Catálogo de Aves')
    @section('botones')
    <div class="header-buttons">
        <a href="{{route('acceso')}}">Iniciar Sesión</a>
        <a href="{{route('registro')}}">Registrarse</a>
    </div>
    @endsection
</header>
@section('content')
<div class="container">

    <!-- Gallinas -->
    <div class="category">
        <h2>🐔 Pollitos</h2>
        <div class="bird-grid">
            @for ($i = 0; $i < 10; $i++)
                <div class="bird-card">
                <img src="https://via.placeholder.com/300x150" alt="Gallina Autóctona">
                <div class="info">
                    <h3>Gallina Autóctona</h3>
                    <p>Especie local adaptada a nuestro clima y condiciones.</p>
                </div>
            </div>
            @endfor
            
            <!-- Agrega más aves aquí -->
        </div>
    </div>

    <!-- Patos -->
    <div class="category">
        <h2>🥚 Huevos</h2>
        <div class="bird-grid">
            <div class="bird-card">
                <img src="https://via.placeholder.com/300x150" alt="Pato Mandarín">
                <div class="info">
                    <h3>Pato Mandarín</h3>
                    <p>Especie ornamental de colores vibrantes.</p>
                </div>
            </div>
            <div class="bird-card">
                <img src="https://via.placeholder.com/300x150" alt="Cerceta">
                <div class="info">
                    <h3>Cerceta</h3>
                    <p>Pequeño y activo, ideal para estanques.</p>
                </div>
            </div>
            <!-- Agrega más patos aquí -->
        </div>
    </div>

    <!-- Agrega más categorías como Faisanes, Pavos Reales, Palomas, etc. -->

</div>
@endsection

