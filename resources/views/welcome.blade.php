@extends('layouts.app')

@section('title', 'UCSC - HabilProf')

@section('content')
    <!-- Título -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 text-center">Gestión de Habilitaciones Profesionales</h1>
    </div>

    <!-- Tarjetas Estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-md border border-gray-200 border-l-4 border-l-[#404041] p-5">
            <span class="font-mono text-xs font-semibold text-gray-500 uppercase tracking-wider">Habilitaciones Activas</span>
            <div class="text-2xl font-extrabold text-gray-900 mt-1">📊 {{ $total }}</div>
        </div>
    
        <div class="bg-white rounded-xl shadow-md border border-gray-200 border-l-4 border-l-[#404041] p-5">
            <span class="font-mono text-xs font-semibold text-gray-500 uppercase tracking-wider">Proyecto Ingeniería</span>
            <div class="text-2xl font-extrabold text-gray-900 mt-1">🔧 {{ $countPring }}</div>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-200 border-l-4 border-l-[#404041] p-5">
            <span class="font-mono text-xs font-semibold text-gray-500 uppercase tracking-wider">Proyecto Investigación</span>
            <div class="text-2xl font-extrabold text-gray-900 mt-1">📚 {{ $countPrinv }}</div>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-200 border-l-4 border-l-[#404041] p-5">
            <span class="font-mono text-xs font-semibold text-gray-500 uppercase tracking-wider">Práctica Tutelada</span>
            <div class="text-2xl font-extrabold text-gray-900 mt-1">👥 {{ $countPrTut }}</div>
        </div>
    </div>

    <!-- Botones de Acción Rápida -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-8">
        <a href="{{ route('habilitaciones.create') }}" 
           class="flex justify-center items-center px-4 py-2.5 bg-[#dd120b] hover:bg-red-700 text-white font-medium rounded-lg text-sm shadow-xs transition duration-150">
            <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Nueva habilitación
        </a>

        <a href="{{ route('habilitaciones.FormularioSemestral') }}" 
           class="flex justify-center items-center px-4 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg text-sm shadow-xs transition duration-150">
            <svg class="w-5 h-5 mr-2 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            Listados Habilitación
        </a>

        <a href="{{ route('habilitaciones.FormularioProfesor') }}" 
           class="flex justify-center items-center px-4 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg text-sm shadow-xs transition duration-150">
            <svg class="w-5 h-5 mr-2 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Listado Habilitaciones por Profesor
        </a>
    </div>

    <!-- Tabla de Últimas Habilitaciones -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center">
            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h2 class="text-sm font-semibold text-gray-700">Últimas 5 Habilitaciones Registradas</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 font-semibold">RUT Alumno</th>
                        <th class="px-6 py-3 font-semibold">Nombre Alumno</th>
                        <th class="px-6 py-3 font-semibold">Modalidad</th>
                        <th class="px-6 py-3 font-semibold">Semestre</th>
                        <th class="px-6 py-3 font-semibold">Nota</th>
                        <th class="px-6 py-3 font-semibold">Descripción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($ultimas as $h)
                        <tr class="even:bg-gray-50/60 hover:bg-blue-50/50 transition duration-150">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $h->rut_Alumno }}-{{ $h->DV }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $h->nombre_Alumno }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $h->tipo_HabilProf }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $h->semestre_inicio }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ $h->nota ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 max-w-xs truncate">
                                {{ $h->descripcion ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400 italic">
                                No hay habilitaciones recientes
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection