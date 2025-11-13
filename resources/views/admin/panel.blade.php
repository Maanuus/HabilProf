@extends('layouts.app')

@section('content')
<div class="container py-4">
    @include('partials._sync_notification')
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Panel Administración - Sincronización Modulos</h3>
        <a href="{{ route('admin.sync-history') }}" class="btn btn-info">
            <i class="bi bi-clock-history"></i> Ver Historial de Cambios
        </a>
    </div>

    @if(session('sync_result'))
        @php $r = session('sync_result'); @endphp
        <div class="alert alert-success">
            <strong>Sincronización ejecutada.</strong>
            <div>Alumnos actualizados: {{ $r['incompletos']['alumnos_actualizados'] }} | Profesores actualizados: {{ $r['incompletos']['profesores_actualizados'] }}</div>
            <div>Notas: Total {{ $r['notas']['total_notas'] }} | Aprobadas: {{ $r['notas']['aprobadas'] }} | Reprobadas: {{ $r['notas']['reprobadas'] }}</div>
            @if(!empty($r['incompletos']['errores']))
                <hr>
                <strong>Observaciones:</strong>
                <ul class="small mb-0">
                    @foreach($r['incompletos']['errores'] as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    @include('admin._incompletos', [
        'alumnosIncompletos' => $alumnosIncompletos,
        'profesoresIncompletos' => $profesoresIncompletos,
    ])

    <form action="{{ route('admin.sync') }}" method="post" class="mt-3">
        @csrf
        <button class="btn btn-primary">
            Ejecutar sincronización manual
        </button>
    </form>
</div>
@endsection
