@extends('plantillas.inicio')
@section('h1', 'Auditoría del Sistema')

@section('contenido')
<div class="auditoria-container">
    {{-- Header con estadísticas --}}
    <div class="page-header">
        <div class="header-content">
            <svg class="header-icon" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="header-text">
                <h2 class="header-title">Bitácora de Auditoría</h2>
                <p class="header-subtitle">Registro completo de todas las actividades del sistema</p>
            </div>
        </div>
        
        {{-- Estadísticas rápidas --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon stat-total">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Registros</div>
                    <div class="stat-value">{{ count($auditorias ?? []) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas --}}
    <x-alerta />

    {{-- Card de la tabla --}}
    <div class="audit-card">
        {{-- Filtros y acciones --}}
        <div class="table-toolbar">
            <div class="toolbar-left">
                <div class="search-box">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" 
                           id="searchInput" 
                           class="search-input" 
                           placeholder="Buscar en auditoría..."
                           onkeyup="filterTable()">
                </div>
            </div>
            
            <div class="toolbar-right">
                <span class="results-count" id="resultsCount">
                    Mostrando {{ count($auditorias ?? []) }} registros
                </span>
            </div>
        </div>

        {{-- Tabla responsive --}}
        <div class="table-responsive">
            <table class="audit-table" id="auditTable">
                <thead>
                    <tr>
                        <th class="th-id">#</th>
                        <th class="th-usuario">
                            <div class="th-content">
                                <svg class="th-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                Usuario
                            </div>
                        </th>
                        <th class="th-accion">
                            <div class="th-content">
                                <svg class="th-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                </svg>
                                Acción
                            </div>
                        </th>
                        <th class="th-tabla">
                            <div class="th-content">
                                <svg class="th-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                </svg>
                                Tabla
                            </div>
                        </th>
                        <th class="th-fecha">
                            <div class="th-content">
                                <svg class="th-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                Fecha y Hora
                            </div>
                        </th>
                        <th class="th-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @forelse ($auditorias ?? [] as $auditoria)
                        <tr class="audit-row">
                            <td data-label="#">
                                <span class="row-number">{{ ++$i }}</span>
                            </td>
                            
                            <td data-label="Usuario">
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($auditoria->usuario->nombre ?? 'N', 0, 1)) }}
                                    </div>
                                    <span class="user-name">{{ $auditoria->usuario->nombre ?? 'N/A' }}</span>
                                </div>
                            </td>
                            
                            <td data-label="Acción">
                                <span class="action-badge action-{{ strtolower($auditoria->accion) }}">
                                    @switch(strtolower($auditoria->accion))
                                        @case('crear')
                                        @case('creó')
                                        @case('create')
                                            <svg class="badge-icon" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                                            </svg>
                                            @break
                                        @case('editar')
                                        @case('editó')
                                        @case('actualizar')
                                        @case('update')
                                            <svg class="badge-icon" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                            @break
                                        @case('eliminar')
                                        @case('eliminó')
                                        @case('delete')
                                            <svg class="badge-icon" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            @break
                                        @default
                                            <svg class="badge-icon" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                    @endswitch
                                    {{ ucfirst($auditoria->accion) }}
                                </span>
                            </td>
                            
                            <td data-label="Tabla">
                                <span class="table-badge">
                                    <svg class="badge-icon" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                    </svg>
                                    {{ $auditoria->tabla }}
                                </span>
                            </td>
                            
                            <td data-label="Fecha">
                                <div class="date-cell">
                                    <span class="date-day">
                                        {{ \Carbon\Carbon::parse($auditoria->fecha)->format('d/m/Y') }}
                                    </span>
                                    <span class="date-time">
                                        {{ \Carbon\Carbon::parse($auditoria->fecha)->format('H:i:s') }}
                                    </span>
                                </div>
                            </td>
                            
                            <td data-label="Acciones">
                                <form action="{{ route('auditorias.destroy', $auditoria->id) }}" 
                                      method="POST" 
                                      class="delete-form"
                                      onsubmit="return confirm('¿Eliminar este registro de auditoría?\n\nRegistro: #{{ $i }}\nUsuario: {{ $auditoria->usuario->nombre ?? 'N/A' }}\nAcción: {{ $auditoria->accion }}\n\nEsta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-row">
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-content">
                                    <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="empty-text">No hay registros de auditoría</p>
                                    <p class="empty-subtext">El sistema comenzará a registrar las actividades</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Botones de acción --}}
    <div class="action-bar">
        @if(count($auditorias ?? []) > 0)
            <form action="{{ route('auditorias.destroyAll') }}" 
                  method="POST" 
                  class="delete-all-form"
                  onsubmit="return confirmDeleteAll()">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg class="btn-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Eliminar Todos los Registros
                </button>
            </form>
        @endif
        
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn btn-secondary">
            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver al Panel
        </a>
    </div>
</div>

<style>
/* ================================
   CONTENEDOR PRINCIPAL
   ================================ */
.auditoria-container {
    max-width: 1600px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
}

/* ================================
   HEADER
   ================================ */
.page-header {
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.header-icon {
    width: 3rem;
    height: 3rem;
    color: #8b5cf6;
    flex-shrink: 0;
}

.header-text {
    flex: 1;
}

.header-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1a202c;
    margin: 0 0 0.5rem 0;
}

.header-subtitle {
    color: #718096;
    font-size: 0.95rem;
    margin: 0;
}

/* ================================
   ESTADÍSTICAS
   ================================ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.stat-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 0.75rem;
}

.stat-icon svg {
    width: 2rem;
    height: 2rem;
    color: white;
}

.stat-total {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
}

.stat-content {
    flex: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: #718096;
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1a202c;
}

/* ================================
   AUDIT CARD
   ================================ */
.audit-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

/* ================================
   TOOLBAR
   ================================ */
.table-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: #f7fafc;
    border-bottom: 1px solid #e2e8f0;
    gap: 1rem;
}

.toolbar-left,
.toolbar-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.search-box {
    position: relative;
    flex: 1;
    min-width: 300px;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 1.25rem;
    height: 1.25rem;
    color: #a0aec0;
    pointer-events: none;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 2px solid #e2e8f0;
    border-radius: 0.5rem;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    background: white;
}

.search-input:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.results-count {
    font-size: 0.875rem;
    color: #718096;
    font-weight: 500;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #4a5568;
    background: white;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-action svg {
    width: 1.125rem;
    height: 1.125rem;
}

.btn-action:hover {
    border-color: #cbd5e0;
    background: #f7fafc;
    transform: translateY(-2px);
}

/* ================================
   TABLA
   ================================ */
.table-responsive {
    overflow-x: auto;
}

.audit-table {
    width: 100%;
    border-collapse: collapse;
}

.audit-table thead {
    background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
}

.audit-table th {
    padding: 1rem 1.5rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    color: #4a5568;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #e2e8f0;
}

.th-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.th-icon {
    width: 1rem;
    height: 1rem;
    color: #8b5cf6;
}

.th-id {
    width: 80px;
}

.th-acciones {
    width: 140px;
    text-align: center;
}

.audit-row {
    border-bottom: 1px solid #f7fafc;
    transition: all 0.2s ease;
}

.audit-row:hover {
    background: #fafbfc;
}

.audit-table td {
    padding: 1.25rem 1.5rem;
    color: #2d3748;
    font-size: 0.95rem;
}

/* ================================
   CELDAS ESPECIALES
   ================================ */
.row-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    background: #edf2f7;
    border-radius: 0.5rem;
    font-weight: 700;
    color: #4a5568;
    font-size: 0.875rem;
}

.user-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    border-radius: 50%;
    color: white;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
}

.user-name {
    font-weight: 600;
    color: #1a202c;
}

/* ================================
   BADGES
   ================================ */
.action-badge,
.table-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.875rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 600;
    white-space: nowrap;
}

.badge-icon {
    width: 1rem;
    height: 1rem;
}

/* Colores por tipo de acción */
.action-crear,
.action-creó,
.action-create {
    background: #d1fae5;
    color: #065f46;
}

.action-editar,
.action-editó,
.action-actualizar,
.action-update {
    background: #dbeafe;
    color: #1e40af;
}

.action-eliminar,
.action-eliminó,
.action-delete {
    background: #fee2e2;
    color: #991b1b;
}

.table-badge {
    background: #f3e8ff;
    color: #6b21a8;
}

/* ================================
   FECHA
   ================================ */
.date-cell {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.date-day {
    font-weight: 600;
    color: #1a202c;
}

.date-time {
    font-size: 0.875rem;
    color: #718096;
}

/* ================================
   BOTÓN DELETE ROW
   ================================ */
.btn-delete-row {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.875rem;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border: none;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-delete-row svg {
    width: 1rem;
    height: 1rem;
}

.btn-delete-row:hover {
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    transform: translateY(-2px);
}

/* ================================
   EMPTY STATE
   ================================ */
.empty-state {
    padding: 4rem 2rem !important;
    text-align: center;
}

.empty-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.empty-icon {
    width: 5rem;
    height: 5rem;
    color: #cbd5e0;
}

.empty-text {
    font-size: 1.25rem;
    font-weight: 600;
    color: #4a5568;
    margin: 0;
}

.empty-subtext {
    font-size: 0.95rem;
    color: #718096;
    margin: 0;
}

/* ================================
   ACTION BAR
   ================================ */
.action-bar {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 1.5rem;
    background: #f7fafc;
    border-radius: 1rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1.75rem;
    font-size: 0.95rem;
    font-weight: 600;
    border-radius: 0.5rem;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-icon {
    width: 1.25rem;
    height: 1.25rem;
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    transform: translateY(-2px);
}

.btn-secondary {
    background: white;
    color: #4a5568;
    border: 2px solid #e2e8f0;
}

.btn-secondary:hover {
    background: #f7fafc;
    border-color: #cbd5e0;
    transform: translateY(-2px);
}

/* ================================
   RESPONSIVE
   ================================ */
@media (max-width: 1024px) {
    .table-toolbar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-box {
        min-width: 100%;
    }
    
    .toolbar-right {
        justify-content: space-between;
    }
}

@media (max-width: 768px) {
    .auditoria-container {
        padding: 1rem;
    }
    
    .header-content {
        flex-direction: column;
        gap: 1rem;
    }
    
    .header-icon {
        width: 2.5rem;
        height: 2.5rem;
    }
    
    .header-title {
        font-size: 1.5rem;
    }
    
    /* Tabla responsiva tipo tarjetas */
    .audit-table thead {
        display: none;
    }
    
    .audit-row {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .audit-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.875rem 1rem;
        border-bottom: 1px solid #f7fafc;
    }
    
    .audit-table td:last-child {
        border-bottom: none;
        justify-content: center;
    }
    
    .audit-table td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #4a5568;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .user-cell {
        flex-direction: row-reverse;
    }
    
    .action-bar {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
}
</style>

<script>
// Filtro de búsqueda en tiempo real
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('auditTable');
    const rows = table.getElementsByTagName('tr');
    let visibleCount = 0;
    
    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let found = false;
        
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        
        if (found) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    }
    
    // Actualizar contador de resultados
    const resultsCount = document.getElementById('resultsCount');
    if (resultsCount) {
        resultsCount.textContent = `Mostrando ${visibleCount} de {{ count($auditorias ?? []) }} registros`;
    }
}

// Confirmación mejorada para eliminar todos
function confirmDeleteAll() {
    const totalRecords = {{ count($auditorias ?? []) }};
    const message = `⚠️ ADVERTENCIA: ACCIÓN CRÍTICA\n\n` +
                   `Estás a punto de ELIMINAR TODOS los registros de auditoría.\n\n` +
                   `Total de registros que se eliminarán: ${totalRecords}\n\n` +
                   `Esta acción es IRREVERSIBLE y eliminará permanentemente:\n` +
                   `• Todos los registros de actividades\n` +
                   `• Todo el historial del sistema\n` +
                   `• Toda la trazabilidad de cambios\n\n` +
                   `¿Estás COMPLETAMENTE SEGURO de continuar?`;
    
    if (!confirm(message)) {
        return false;
    }
    
    // Segunda confirmación
    const secondConfirm = prompt(
        `Para confirmar, escribe "ELIMINAR TODO" (en mayúsculas):`
    );
    
    return secondConfirm === "ELIMINAR TODO";
}
</script>
@endsection