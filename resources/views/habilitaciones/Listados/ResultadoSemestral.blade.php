@extends('layouts.app')

@section('title', 'UCSC - Resultados Históricos')

@section('content')
    <!-- Tarjeta de Contenido -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            
            <!-- Encabezado con Título y Botón Atrás -->
            <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Listado Histórico de Habilitaciones</h1>
                    <p class="text-xs text-gray-500 mt-1">
                        Resultados {{ $solo_semestre ? 'del semestre' : 'desde el semestre' }} 
                        <span class="font-semibold text-gray-700">{{ $semestre_inicio }}</span>
                    </p>
                </div>

                <a href="{{ route('habilitaciones.FormularioSemestral') }}" 
                   class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition duration-150 shadow-xs">
                    ← Atrás
                </a>
            </div>

            <!-- Cuerpo de la Tabla -->
            @if ($habilitaciones->isEmpty())
                <div class="p-8 text-center text-gray-500 italic">
                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg text-amber-800 text-sm inline-block">
                        No se encontraron habilitaciones para el semestre indicado.
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3.5 font-semibold">RUT</th>
                                <th class="px-6 py-3.5 font-semibold">Nombre</th>
                                <th class="px-6 py-3.5 font-semibold">Tipo Habilitación</th>
                                <th class="px-6 py-3.5 font-semibold">Semestre Inicio</th>
                                <th class="px-6 py-3.5 font-semibold">Nota</th>
                                <th class="px-6 py-3.5 font-semibold">Datos Adicionales</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($habilitaciones as $h)
                                <!-- Cebra alternada mediante 'even:bg-gray-50/60' -->
                                <tr class="even:bg-gray-50/60 hover:bg-blue-50/40 transition duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $h->rut_Alumno }}-{{ $h->DV }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        {{ $h->nombre_Alumno }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            {{ $h->tipo_HabilProf }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                        {{ $h->semestre_inicio }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">
                                        {{ $h->nota ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-600 max-w-sm">
                                        @if($h->tipo_HabilProf == 'Pring')
                                            <div class="space-y-0.5">
                                                <p><strong class="text-gray-800">Título:</strong> {{ $h->titulo_Pring ?? 'N/A' }}</p>
                                                <p><strong class="text-gray-800">Descripción:</strong> {{ $h->descripcion ?? 'N/A' }}</p>
                                            </div>
                                        @elseif($h->tipo_HabilProf == 'Prinv')
                                            <div class="space-y-0.5">
                                                <p><strong class="text-gray-800">Título:</strong> {{ $h->titulo_Prinv ?? 'N/A' }}</p>
                                                <p><strong class="text-gray-800">Descripción:</strong> {{ $h->descripcion ?? 'N/A' }}</p>
                                            </div>
                                        @elseif($h->tipo_HabilProf == 'PrTut')
                                            <div class="space-y-0.5">
                                                <p><strong class="text-gray-800">Empresa:</strong> {{ $h->nombre_Empresa ?? 'N/A' }}</p>
                                                <p><strong class="text-gray-800">Supervisor:</strong> {{ $h->nombre_Supervisor ?? 'N/A' }}</p>
                                            </div>
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
@endsection