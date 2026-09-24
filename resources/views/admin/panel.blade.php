@extends('layouts.app')

@section('title', 'UCSC - Panel de Sincronización')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Panel de Control: Sincronización Externa</h1>
        <p class="text-sm text-gray-500 mt-1">Integración con base de datos curricular <span class="font-mono font-semibold">Modulos</span></p>
    </div>
    <a href="{{ route('admin.sync-history') }}" 
       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg text-sm shadow-xs transition">
        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Ver Historial de Cambios
    </a>
</div>

@if(session('sync_error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-900 shadow-xs">
        <div class="flex items-center space-x-2 font-bold text-red-800 mb-1">
            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            <span>Error de Sincronización</span>
        </div>
        <p class="text-xs text-red-700">{{ session('sync_error') }}</p>
    </div>
@endif

@if(session('sync_result'))
    @php $r = session('sync_result'); @endphp
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-900 shadow-xs">
        <div class="flex items-center space-x-2 font-bold text-emerald-800 mb-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span>Sincronización ejecutada con éxito</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
            <p>Alumnos actualizados: <strong>{{ $r['incompletos']['alumnos_actualizados'] }}</strong> | Profesores actualizados: <strong>{{ $r['incompletos']['profesores_actualizados'] }}</strong></p>
            <p>Notas sincronizadas: <strong>{{ $r['notas']['total_notas'] }}</strong> (Aprobadas: {{ $r['notas']['aprobadas'] }} | Reprobadas: {{ $r['notas']['reprobadas'] }})</p>
        </div>
        @if(!empty($r['incompletos']['errores']))
            <div class="mt-3 pt-3 border-t border-emerald-200 text-xs">
                <strong>Observaciones:</strong>
                <ul class="list-disc list-inside mt-1 space-y-0.5 text-emerald-800">
                    @foreach($r['incompletos']['errores'] as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif

@include('admin._incompletos', [
    'alumnosIncompletos' => $alumnosIncompletos,
    'profesoresIncompletos' => $profesoresIncompletos,
])

<div class="mt-6 flex justify-end">
    <form action="{{ route('admin.sync') }}" method="POST">
        @csrf
        <button type="submit" 
                class="px-6 py-2.5 bg-[#dd120b] hover:bg-red-700 text-white font-semibold rounded-lg text-sm transition duration-150 shadow-md cursor-pointer flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Ejecutar Sincronización Manual
        </button>
    </form>
</div>
@endsection
