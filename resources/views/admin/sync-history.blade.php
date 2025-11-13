@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Historial de Cambios de Sincronización</h2>
        <div>
            <a href="{{ route('admin.panel') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver al Panel
            </a>
            <form action="{{ route('admin.sync-history.clear') }}" method="POST" class="d-inline" 
                  onsubmit="return confirm('¿Estás seguro de limpiar todo el historial?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Limpiar Historial
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.sync-history') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="tipo" class="form-label">Tipo de Entidad</label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="">Todos</option>
                        <option value="Alumno" {{ request('tipo') === 'Alumno' ? 'selected' : '' }}>Alumno</option>
                        <option value="Profesor" {{ request('tipo') === 'Profesor' ? 'selected' : '' }}>Profesor</option>
                        <option value="Habilitacion_Profesional" {{ request('tipo') === 'Habilitacion_Profesional' ? 'selected' : '' }}>Habilitación Profesional</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="rut" class="form-label">RUT</label>
                    <input type="text" name="rut" id="rut" class="form-control" 
                           placeholder="Ej: 12345678-9" value="{{ request('rut') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                    <a href="{{ route('admin.sync-history') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de cambios -->
    @if(count($cambios) > 0)
        <div class="card">
            <div class="card-body">
                <p class="text-muted">Total de cambios: <strong>{{ $total }}</strong></p>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Fecha/Hora</th>
                                <th>Tipo</th>
                                <th>RUT</th>
                                <th>Campo</th>
                                <th>Valor Anterior</th>
                                <th>Valor Nuevo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cambios as $cambio)
                                <tr>
                                    <td>{{ $cambio['timestamp'] }}</td>
                                    <td>
                                        <span class="badge bg-{{ $cambio['tipo'] === 'Alumno' ? 'primary' : ($cambio['tipo'] === 'Profesor' ? 'success' : 'info') }}">
                                            {{ $cambio['tipo'] }}
                                        </span>
                                    </td>
                                    <td><code>{{ $cambio['rut'] }}</code></td>
                                    <td><strong>{{ $cambio['campo'] }}</strong></td>
                                    <td>
                                        @if(empty($cambio['valor_anterior']))
                                            <span class="text-muted fst-italic">(vacío)</span>
                                        @else
                                            <span class="text-danger">{{ $cambio['valor_anterior'] }}</span>
                                        @endif
                                    </td>
                                    <td><span class="text-success">{{ $cambio['valor_nuevo'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación simple -->
                @if($total > $perPage)
                    <nav>
                        <ul class="pagination justify-content-center">
                            @if($page > 1)
                                <li class="page-item">
                                    <a class="page-link" href="?page={{ $page - 1 }}&tipo={{ request('tipo') }}&rut={{ request('rut') }}">Anterior</a>
                                </li>
                            @endif
                            
                            <li class="page-item disabled">
                                <span class="page-link">Página {{ $page }} de {{ ceil($total / $perPage) }}</span>
                            </li>

                            @if($page * $perPage < $total)
                                <li class="page-item">
                                    <a class="page-link" href="?page={{ $page + 1 }}&tipo={{ request('tipo') }}&rut={{ request('rut') }}">Siguiente</a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> No hay cambios registrados{{ request('tipo') || request('rut') ? ' con los filtros aplicados' : '' }}.
        </div>
    @endif
</div>
@endsection
