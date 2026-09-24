@extends('layouts.app')

@section('title', 'UCSC - Historial de Sincronización')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Historial de Sincronización</h1>
        <p class="text-sm text-gray-500 mt-0.5">Auditoría detallada de cambios detectados e integrados</p>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.panel') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
            ← Volver al Panel
        </a>
        <form action="{{ route('admin.sync-history.clear') }}" method="POST" 
              onsubmit="return confirm('¿Estás seguro de que deseas purgar todo el historial de sincronización?')">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 text-sm font-semibold rounded-lg transition duration-150 cursor-pointer flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Limpiar Historial
            </button>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm flex items-center justify-between shadow-xs">
        <span>{{ session('success') }}</span>
    </div>
@endif

<!-- Formulario Filtros -->
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-5 mb-6">
    <form method="GET" action="{{ route('admin.sync-history') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4">
        <div class="sm:col-span-5">
            <label for="tipo" class="block text-xs font-semibold text-gray-600 uppercase mb-1">Tipo de Entidad</label>
            <select name="tipo" id="tipo" class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition">
                <option value="">Todas las entidades</option>
                <option value="Alumno" {{ request('tipo') === 'Alumno' ? 'selected' : '' }}>Alumno</option>
                <option value="Profesor" {{ request('tipo') === 'Profesor' ? 'selected' : '' }}>Profesor</option>
                <option value="Habilitacion_Profesional" {{ request('tipo') === 'Habilitacion_Profesional' ? 'selected' : '' }}>Habilitación Profesional</option>
            </select>
        </div>

        <div class="sm:col-span-4">
            <label for="rut" class="block text-xs font-semibold text-gray-600 uppercase mb-1">Filtrar por RUT</label>
            <input type="text" name="rut" id="rut" 
                   class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                   placeholder="Ej: 12345678-9" value="{{ request('rut') }}">
        </div>

        <div class="sm:col-span-3 flex items-end space-x-2">
            <button type="submit" 
                    class="px-4 py-2 bg-[#dd120b] hover:bg-red-700 text-white font-semibold text-sm rounded-lg transition duration-150 shadow-xs cursor-pointer grow">
                Filtrar
            </button>
            <a href="{{ route('admin.sync-history') }}" 
               class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-lg transition">
                Limpiar
            </a>
        </div>
    </form>
</div>

<!-- Tabla de Registros -->
@if(count($cambios) > 0)
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 border-b border-gray-200 px-6 py-3.5 flex justify-between items-center">
            <span class="text-xs text-gray-500">Total de eventos: <strong>{{ $total }}</strong></span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Fecha / Hora</th>
                        <th class="px-6 py-3 font-semibold">Tipo</th>
                        <th class="px-6 py-3 font-semibold">RUT</th>
                        <th class="px-6 py-3 font-semibold">Campo Modificado</th>
                        <th class="px-6 py-3 font-semibold">Valor Anterior</th>
                        <th class="px-6 py-3 font-semibold">Valor Nuevo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($cambios as $cambio)
                        <tr class="even:bg-gray-50/60 hover:bg-blue-50/40 transition duration-150">
                            <td class="px-6 py-3.5 font-mono text-xs whitespace-nowrap text-gray-500">
                                {{ $cambio['timestamp'] }}
                            </td>
                            <td class="px-6 py-3.5 whitespace-nowrap">
                                @php
                                    $colorBadge = match($cambio['tipo'] ?? '') {
                                        'Alumno' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'Profesor' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        default => 'bg-purple-50 text-purple-700 border-purple-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorBadge }}">
                                    {{ $cambio['tipo'] }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 font-mono text-xs font-semibold text-gray-800 whitespace-nowrap">
                                {{ $cambio['rut'] }}
                            </td>
                            <td class="px-6 py-3.5 font-semibold text-gray-800">
                                {{ $cambio['campo'] }}
                            </td>
                            <td class="px-6 py-3.5 text-xs text-red-600 max-w-xs truncate">
                                {{ empty($cambio['valor_anterior']) ? '(vacío)' : $cambio['valor_anterior'] }}
                            </td>
                            <td class="px-6 py-3.5 text-xs font-semibold text-emerald-700 max-w-xs truncate">
                                {{ $cambio['valor_nuevo'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación Simple -->
        @if($total > $perPage)
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between text-sm">
                <span class="text-xs text-gray-500">
                    Página {{ $page }} de {{ ceil($total / $perPage) }}
                </span>
                <div class="flex space-x-2">
                    @if($page > 1)
                        <a href="?page={{ $page - 1 }}&tipo={{ request('tipo') }}&rut={{ request('rut') }}" 
                           class="px-3 py-1.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 text-xs font-medium">
                            ← Anterior
                        </a>
                    @endif
                    @if($page * $perPage < $total)
                        <a href="?page={{ $page + 1 }}&tipo={{ request('tipo') }}&rut={{ request('rut') }}" 
                           class="px-3 py-1.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 text-xs font-medium">
                            Siguiente →
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
@else
    <div class="p-8 bg-white rounded-xl shadow-md border border-gray-200 text-center text-gray-500 italic text-sm">
        No hay cambios de sincronización registrados con los criterios seleccionados.
    </div>
@endif
@endsection
