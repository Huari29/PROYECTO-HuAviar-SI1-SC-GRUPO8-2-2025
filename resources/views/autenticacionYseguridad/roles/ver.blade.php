@extends('plantillas.inicio')
@section('h1', 'Detalles del Rol')

@section('contenido')
<div class="container">
    <x-alerta />
    
    <div class="detail-box">
        {{-- INFORMACIÓN DEL ROL --}}
        <div class="rol-info">
            <div class="info-header">
                <h2 style="color:#ef8504; margin:0;">
                    🎭 {{ $rol->descripcion }}
                </h2>
                <div class="info-badge">
                    ID: {{ $rol->id }}
                </div>
            </div>
            
            <div class="info-stats">
                <div class="stat-card">
                    <div class="stat-icon">🔐</div>
                    <div class="stat-content">
                        <div class="stat-label">Permisos Asignados</div>
                        <div class="stat-value">{{ $rol->permisos->count() }}</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-content">
                        <div class="stat-label">Usuarios con este Rol</div>
                        <div class="stat-value">{{ $rol->usuarios->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PERMISOS DEL ROL --}}
        <div class="permisos-section">
            <h3 style="color:#333; margin-bottom:20px; border-bottom:2px solid #ef8504; padding-bottom:10px;">
                📋 Permisos de este Rol
            </h3>
            
            @if($rol->permisos->isEmpty())
                <div style="padding:20px; background:#fff3cd; border-left:4px solid #ffc107; border-radius:5px;">
                    <strong>⚠️ Sin permisos asignados</strong>
                    <p style="margin:5px 0 0 0; color:#666;">
                        Este rol no tiene ningún permiso asignado actualmente.
                    </p>
                </div>
            @else
                @php
                    $permisosAgrupados = $rol->permisos->groupBy('modulo');
                @endphp
                
                <div class="permisos-grid">
                    @foreach($permisosAgrupados as $modulo => $permisos)
                        <div class="modulo-card">
                            <div class="modulo-header">
                                <h4>📁 {{ ucfirst($modulo) }}</h4>
                                <span class="badge">{{ $permisos->count() }} permisos</span>
                            </div>
                            <div class="modulo-body">
                                <ul class="permisos-list">
                                    @foreach($permisos as $permiso)
                                        <li>
                                            <span class="permiso-icon">✓</span>
                                            <span class="permiso-name">{{ $permiso->nombre }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- USUARIOS CON ESTE ROL --}}
        @if($rol->usuarios->isNotEmpty())
        <div class="usuarios-section">
            <h3 style="color:#333; margin-bottom:20px; border-bottom:2px solid #2196F3; padding-bottom:10px;">
                👥 Usuarios con este Rol ({{ $rol->usuarios->count() }})
            </h3>
            
            <div class="usuarios-grid">
                @foreach($rol->usuarios as $usuario)
                    <div class="usuario-card">
                        <div class="usuario-avatar">
                            {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                        </div>
                        <div class="usuario-info">
                            <strong>{{ $usuario->nombre }}</strong>
                            <small>{{ $usuario->email }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- BOTONES DE ACCIÓN --}}
        <div class="action-buttons">
            {{-- EDITAR --}}
            @can('roles.editar')
                <a href="{{ route('rols.edit', $rol->id) }}" class="btn btn-edit">
                    ✏️ Editar
                </a>
            @endcan
            
            {{-- VOLVER --}}
            <a href="{{ route('rols.index') }}" class="btn btn-back">
                ⬅️ Volver
            </a>
            
            {{-- ELIMINAR --}}
            @can('roles.eliminar')
                @if($rol->usuarios->count() === 0)
                    <form action="{{ route('rols.destroy', $rol->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete" 
                                onclick="return confirm('¿Estás seguro de eliminar el rol {{ $rol->descripcion }}?\n\nEsta acción no se puede deshacer.')">
                            🗑️ Eliminar
                        </button>
                    </form>
                @else
                    <button class="btn btn-delete" disabled title="No se puede eliminar porque hay {{ $rol->usuarios->count() }} usuario(s) asignado(s)">
                        🗑️ Eliminar ({{ $rol->usuarios->count() }} usuarios asignados)
                    </button>
                @endif
            @endcan
        </div>
    </div>
</div>

<style>
    .detail-box {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Información del Rol */
    .rol-info {
        margin-bottom: 30px;
    }

    .info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .info-badge {
        background: #e3f2fd;
        color: #2196F3;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
    }

    .info-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        color: white;
    }

    .stat-card:nth-child(2) {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stat-icon {
        font-size: 40px;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        font-size: 12px;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
    }

    /* Sección de Permisos */
    .permisos-section {
        margin-bottom: 30px;
    }

    .permisos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .modulo-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        transition: box-shadow 0.3s;
    }

    .modulo-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .modulo-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modulo-header h4 {
        margin: 0;
        font-size: 16px;
    }

    .badge {
        background: rgba(255,255,255,0.2);
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .modulo-body {
        padding: 15px;
        background: #fafafa;
    }

    .permisos-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .permisos-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px;
        margin-bottom: 5px;
        background: white;
        border-radius: 5px;
        transition: background 0.2s;
    }

    .permisos-list li:hover {
        background: #f0f0f0;
    }

    .permiso-icon {
        color: #4CAF50;
        font-weight: bold;
        font-size: 14px;
    }

    .permiso-name {
        font-size: 14px;
        color: #333;
    }

    /* Sección de Usuarios */
    .usuarios-section {
        margin-bottom: 30px;
    }

    .usuarios-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }

    .usuario-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f9f9f9;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .usuario-card:hover {
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .usuario-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
    }

    .usuario-info {
        flex: 1;
    }

    .usuario-info strong {
        display: block;
        color: #333;
        margin-bottom: 3px;
    }

    .usuario-info small {
        color: #666;
        font-size: 12px;
    }

    /* Botones de Acción */
    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .btn {
        padding: 12px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }

    .btn-edit {
        background: #2196F3;
        color: white;
    }

    .btn-edit:hover {
        background: #1976D2;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(33, 150, 243, 0.3);
    }

    .btn-back {
        background: #607D8B;
        color: white;
    }

    .btn-back:hover {
        background: #455A64;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(96, 125, 139, 0.3);
    }

    .btn-delete {
        background: #f44336;
        color: white;
    }

    .btn-delete:hover:not(:disabled) {
        background: #d32f2f;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(244, 67, 54, 0.3);
    }

    .btn-delete:disabled {
        background: #ccc;
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .info-header {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }

        .permisos-grid,
        .usuarios-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endsection