@extends('layouts.app')

@section('title', 'UCSC - Editar Habilitación #' . ($habilitacion['id_Habilitacion'] ?? $habilitacion['id_habilitacion']))

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 sm:p-8">
        
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
            <h1 class="text-xl font-bold text-gray-900">Editar Habilitación #{{ $habilitacion['id_Habilitacion'] ?? $habilitacion['id_habilitacion'] }}</h1>
            <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800">
                ← Volver al Inicio
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                <div class="font-semibold mb-1">Corrige los siguientes errores:</div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('habilitaciones.update', $habilitacion['id_Habilitacion'] ?? $habilitacion['id_habilitacion']) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            @php
                $tipoActual = old('tipo_HabilProf', $habilitacion['tipo_HabilProf'] ?? '');
            @endphp

            <!-- Datos Principales -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                <div class="sm:col-span-5">
                    <label for="rut" class="block text-sm font-semibold text-gray-700 mb-1">RUT Alumno</label>
                    <input type="text" name="rut" id="rut"
                           class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                           value="{{ old('rut', $habilitacion['rut'] ?? (($habilitacion['rut_Alumno'] ?? '').'-'.($habilitacion['DV'] ?? ''))) }}" required>
                </div>

                <div class="sm:col-span-7">
                    <label for="nombre_alumno" class="block text-sm font-semibold text-gray-700 mb-1">Nombre Alumno</label>
                    <input type="text" name="nombre_alumno" id="nombre_alumno"
                           class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                           value="{{ old('nombre_alumno', $habilitacion['nombre_alumno'] ?? ($habilitacion['nombre_Alumno'] ?? '')) }}" required>
                </div>

                <div class="sm:col-span-6">
                    <label for="carrera" class="block text-sm font-semibold text-gray-700 mb-1">Carrera</label>
                    <input type="text" name="carrera" id="carrera"
                           class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                           value="{{ old('carrera', $habilitacion['carrera'] ?? '') }}" required>
                </div>

                <div class="sm:col-span-6">
                    <label for="correo_alumno" class="block text-sm font-semibold text-gray-700 mb-1">Correo Alumno</label>
                    <input type="email" name="correo_alumno" id="correo_alumno"
                           class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                           value="{{ old('correo_alumno', $habilitacion['correo_alumno'] ?? ($habilitacion['correo_Alumno'] ?? '')) }}" required>
                </div>

                <div class="sm:col-span-6">
                    <label for="id_habilitacion" class="block text-sm font-semibold text-gray-700 mb-1">ID Habilitación (Bloqueado)</label>
                    <input type="number" name="id_habilitacion" id="id_habilitacion"
                           class="w-full px-3.5 py-2 border border-gray-200 rounded-lg text-sm bg-gray-100 text-gray-500 cursor-not-allowed"
                           value="{{ $habilitacion['id_Habilitacion'] ?? $habilitacion['id_habilitacion'] }}" readonly>
                </div>

                <div class="sm:col-span-6">
                    <label for="tipo_HabilProf" class="block text-sm font-semibold text-gray-700 mb-1">Tipo Habilitación</label>
                    <select name="tipo_HabilProf" id="tipo_HabilProf" 
                            class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition" required>
                        <option value="Pring" {{ $tipoActual === 'Pring' ? 'selected' : '' }}>Proyecto Ingeniería</option>
                        <option value="Prinv" {{ $tipoActual === 'Prinv' ? 'selected' : '' }}>Proyecto Investigación</option>
                        <option value="PrTut" {{ $tipoActual === 'PrTut' ? 'selected' : '' }}>Práctica Tutelada</option>
                    </select>
                </div>
            </div>

            <!-- Bloque Proyecto -->
            <div id="grupoProyecto" class="p-5 bg-gray-50 border border-gray-200 rounded-xl space-y-4">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Detalles de Proyecto</h3>
                
                <div>
                    <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-1">Título</label>
                    <input type="text" name="titulo" id="titulo" 
                           class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                           value="{{ old('titulo', $habilitacion['titulo'] ?? '') }}">
                </div>

                <div>
                    <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3" 
                              class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition">{{ old('descripcion', $habilitacion['descripcion'] ?? '') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="rut_profesor_comision" class="block text-sm font-semibold text-gray-700 mb-1">RUT Profesor Comisión</label>
                        <input type="text" name="rut_profesor_comision" id="rut_profesor_comision"
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                               value="{{ old('rut_profesor_comision', $habilitacion['rut_profesor_comision'] ?? '') }}">
                    </div>

                    <div>
                        <label for="rut_profesor_coguia" class="block text-sm font-semibold text-gray-700 mb-1">RUT Profesor Co-guía (opcional)</label>
                        <input type="text" name="rut_profesor_coguia" id="rut_profesor_coguia"
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                               value="{{ old('rut_profesor_coguia', $habilitacion['rut_profesor_coguia'] ?? '') }}">
                    </div>
                </div>
            </div>

            <!-- Bloque Práctica Tutelada -->
            <div id="grupoPractica" class="p-5 bg-gray-50 border border-gray-200 rounded-xl space-y-4">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Detalles de Práctica Tutelada</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nombre_Empresa" class="block text-sm font-semibold text-gray-700 mb-1">Nombre Empresa</label>
                        <input type="text" name="nombre_Empresa" id="nombre_Empresa"
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                               value="{{ old('nombre_Empresa', $habilitacion['nombre_Empresa'] ?? '') }}">
                    </div>

                    <div>
                        <label for="nombre_Supervisor" class="block text-sm font-semibold text-gray-700 mb-1">Nombre Supervisor</label>
                        <input type="text" name="nombre_Supervisor" id="nombre_Supervisor"
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                               value="{{ old('nombre_Supervisor', $habilitacion['nombre_Supervisor'] ?? '') }}">
                    </div>
                </div>
            </div>

            <!-- Semestre y Nota -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="semestre_inicio" class="block text-sm font-semibold text-gray-700 mb-1">Semestre Inicio</label>
                    <input type="text" name="semestre_inicio" id="semestre_inicio"
                           class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                           value="{{ old('semestre_inicio', $habilitacion['semestre_inicio'] ?? '') }}" placeholder="Ej: 2026-1">
                </div>

                <div>
                    <label for="nota" class="block text-sm font-semibold text-gray-700 mb-1">Calificación Final (Nota)</label>
                    <input type="number" step="0.1" min="1.0" max="7.0" name="nota" id="nota"
                           class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                           value="{{ old('nota', $habilitacion['nota'] ?? '') }}" placeholder="Ej: 6.5 (Vacío si está en curso)">
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="pt-4 flex items-center justify-between border-t border-gray-200">
                <button type="submit" 
                        class="px-6 py-2.5 bg-[#dd120b] hover:bg-red-700 text-white font-semibold rounded-lg text-sm transition duration-150 shadow-md cursor-pointer">
                    Actualizar Habilitación
                </button>
                <a href="{{ route('home') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const tipoSelect = document.getElementById('tipo_HabilProf');
    const grupoProyecto = document.getElementById('grupoProyecto');
    const grupoPractica = document.getElementById('grupoPractica');

    function setGroupEnabled(groupEl, enabled) {
        groupEl.style.display = enabled ? 'block' : 'none';
        groupEl.querySelectorAll('input, textarea').forEach(el => {
            el.disabled = !enabled;
        });
    }

    function updateUI() {
        const v = tipoSelect.value;
        if (v === 'Pring' || v === 'Prinv') {
            setGroupEnabled(grupoProyecto, true);
            setGroupEnabled(grupoPractica, false);
        } else if (v === 'PrTut') {
            setGroupEnabled(grupoProyecto, false);
            setGroupEnabled(grupoPractica, true);
        } else {
            setGroupEnabled(grupoProyecto, false);
            setGroupEnabled(grupoPractica, false);
        }
    }

    tipoSelect.addEventListener('change', updateUI);
    window.addEventListener('load', updateUI);
</script>
@endpush
