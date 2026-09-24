@extends('layouts.app')

@section('title', 'UCSC - Habilitaciones del Profesor')

@section('content')
@if($resultados->isEmpty())
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8 text-center max-w-2xl mx-auto">
        <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg text-amber-800 text-sm inline-block mb-4">
            El profesor consultado no registra habilitaciones profesionales asociadas con los filtros indicados.
        </div>
        <div>
            <a href="{{ route('habilitaciones.FormularioProfesor') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition">
                ← Volver al formulario de búsqueda
            </a>
        </div>
    </div>
@else
    @php
        $nombreProfesor = $resultados->first()->first()->nombre_Profesor ?? 'Profesor';
        $rutProfesor = $resultados->first()->first()->rut_Profesor ?? '';
        $dvProfesor = $resultados->first()->first()->DV_profesor ?? '';
    @endphp

    <!-- Cabecera de Identificación -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-mono uppercase text-gray-500 font-semibold tracking-wider">Historial Docente</span>
            <h1 class="text-2xl font-bold text-gray-900">{{ $nombreProfesor }}</h1>
            <p class="text-xs text-gray-500 mt-0.5">RUT: <span class="font-mono font-semibold">{{ $rutProfesor }}-{{ $dvProfesor }}</span></p>
        </div>
        <a href="{{ route('habilitaciones.FormularioProfesor') }}" 
           class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition duration-150 shadow-xs">
            ← Nueva Búsqueda
        </a>
    </div>

    <!-- Tablas Agrupadas por Rol del Profesor -->
    <div class="space-y-6">
        @foreach($resultados as $tipo => $habilitaciones)
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 border-b border-gray-200 px-6 py-3.5 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider flex items-center">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#dd120b] mr-2"></span>
                        Rol: {{ $tipo }}
                    </h2>
                    <span class="text-xs bg-gray-200 text-gray-700 font-semibold px-2.5 py-0.5 rounded-full">
                        {{ count($habilitaciones) }} asignaciones
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 font-semibold">RUT Alumno</th>
                                <th class="px-6 py-3 font-semibold">Nombre Alumno</th>
                                <th class="px-6 py-3 font-semibold">Modalidad</th>
                                <th class="px-6 py-3 font-semibold">Semestre Inicio</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($habilitaciones as $h)
                                <tr class="even:bg-gray-50/60 hover:bg-blue-50/40 transition duration-150">
                                    <td class="px-6 py-3.5 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $h->rut_Alumno }}-{{ $h->DV_alumno }}
                                    </td>
                                    <td class="px-6 py-3.5 font-medium text-gray-800">
                                        {{ $h->nombre_Alumno }}
                                    </td>
                                    <td class="px-6 py-3.5 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            {{ $h->tipo_HabilProf }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 whitespace-nowrap font-mono text-xs">
                                        {{ $h->semestre_inicio }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
