@extends('layouts.app')

@section('title', 'UCSC - Nueva Habilitación')

@section('content')
<body class="bg-gray-100 font-sans text-gray-800 min-h-screen flex flex-col">

    <!-- Contenido Principal -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full grow">
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 sm:p-8">
            
            <!-- Encabezado de la vista -->
            <div class="flex items-center justify-center mb-6 pb-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-center text-gray-900">Nueva Habilitación</h1>
            </div>

            <!-- Alerta de Errores -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                    <div class="font-semibold mb-1">Por favor corrige los siguientes errores:</div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario -->
            <form action="{{ route('habilitaciones.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Bloque Datos Principales -->
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                    
                    <div class="sm:col-span-5">
                        <label for="rut" class="block text-sm font-semibold text-gray-700 mb-1">RUT Alumno</label>
                        <input type="text" name="rut" id="rut"
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] focus:border-transparent transition"
                               placeholder="Ej: 12345678-9"
                               value="{{ old('rut') }}" 
                               minlength="8" maxlength="9" required>
                    </div>

                    <div class="sm:col-span-7">
                        <label for="nombre_alumno" class="block text-sm font-semibold text-gray-700 mb-1">Nombre Alumno</label>
                        <input type="text" name="nombre_alumno" id="nombre_alumno"
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] focus:border-transparent transition"
                               placeholder="Nombre Completo" 
                               value="{{ old('nombre_alumno') }}" 
                               maxlength="40" required>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="carrera" class="block text-sm font-semibold text-gray-700 mb-1">Carrera</label>
                        <input type="text" name="carrera" id="carrera"
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] focus:border-transparent transition"
                               placeholder="Ej: Ingeniería Civil Informática" 
                               value="{{ old('carrera') }}" 
                               maxlength="50" required>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="correo_alumno" class="block text-sm font-semibold text-gray-700 mb-1">Correo Alumno</label>
                        <input type="email" name="correo_alumno" id="correo_alumno"
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] focus:border-transparent transition"
                               placeholder="Ej: maria@ing.ucsc.cl" 
                               value="{{ old('correo_alumno') }}" 
                               maxlength="35"
                               pattern=".+@ing\.ucsc\.cl" required>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="id_habilitacion" class="block text-sm font-semibold text-gray-700 mb-1">ID Habilitación</label>
                        <input type="number" name="id_habilitacion" id="id_habilitacion"
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] focus:border-transparent transition"
                               value="{{ old('id_habilitacion') }}" required>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="tipo_HabilProf" class="block text-sm font-semibold text-gray-700 mb-1">Tipo Habilitación</label>
                        <select name="tipo_HabilProf" id="tipo_HabilProf" 
                                class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] focus:border-transparent transition" required>
                            <option value="" disabled selected>Seleccione un tipo</option>
                            <option value="Pring" {{ old('tipo_HabilProf')=='Pring' ? 'selected':'' }}>Proyecto Ingeniería</option>
                            <option value="Prinv" {{ old('tipo_HabilProf')=='Prinv' ? 'selected':'' }}>Proyecto Investigación</option>
                            <option value="PrTut" {{ old('tipo_HabilProf')=='PrTut' ? 'selected':'' }}>Práctica Tutelada</option>
                        </select>
                    </div>
                </div>

                <!-- Campos dinámicos: Proyectos -->
                <div id="grupoProyecto" class="p-5 bg-gray-50 border border-gray-200 rounded-xl space-y-4" style="display:none;">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Detalles del Proyecto</h3>
                    
                    <div>
                        <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-1">Título</label>
                        <input type="text" name="titulo" id="titulo" 
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                               value="{{ old('titulo') }}" maxlength="100">
                    </div>

                    <div>
                        <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3" 
                                  class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition" 
                                  maxlength="500">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="rut_profesor_comision" class="block text-sm font-semibold text-gray-700 mb-1">RUT Profesor Comisión</label>
                            <input type="text" name="rut_profesor_comision" id="rut_profesor_comision"
                                   class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                                   placeholder="Ej: 12345678-9" value="{{ old('rut_profesor_comision') }}"
                                   minlength="8" maxlength="10">
                        </div>

                        <div>
                            <label for="rut_profesor_coguia" class="block text-sm font-semibold text-gray-700 mb-1">RUT Profesor Co-guía (opcional)</label>
                            <input type="text" name="rut_profesor_coguia" id="rut_profesor_coguia"
                                   class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                                   placeholder="Ej: 12345678-9" value="{{ old('rut_profesor_coguia') }}"
                                   minlength="8" maxlength="10">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="rut_profesor_supervisor_proj" class="block text-sm font-semibold text-gray-700 mb-1">RUT Profesor Supervisor</label>
                            <input type="text" name="rut_profesor_supervisor" id="rut_profesor_supervisor_proj"
                                   class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                                   placeholder="Ej: 12345678-9" value="{{ old('rut_profesor_supervisor') }}"
                                   minlength="8" maxlength="10">
                        </div>
                    </div>
                </div>

                <!-- Campos dinámicos: Práctica -->
                <div id="grupoPractica" class="p-5 bg-gray-50 border border-gray-200 rounded-xl space-y-4" style="display:none;">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Detalles de Práctica Tutelada</h3>
                    
                    <div>
                        <label for="nombre_Empresa" class="block text-sm font-semibold text-gray-700 mb-1">Nombre Empresa</label>
                        <input type="text" name="nombre_Empresa" id="nombre_Empresa"
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                               value="{{ old('nombre_Empresa') }}" maxlength="100">
                    </div>

                    <div>
                        <label for="nombre_Supervisor" class="block text-sm font-semibold text-gray-700 mb-1">Nombre Supervisor Empresa</label>
                        <input type="text" name="nombre_Supervisor" id="nombre_Supervisor"
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                               value="{{ old('nombre_Supervisor') }}" maxlength="80">
                    </div>

                    <div>
                        <label for="rut_profesor_supervisor_prac" class="block text-sm font-semibold text-gray-700 mb-1">RUT Profesor Supervisor</label>
                        <input type="text" name="rut_profesor_supervisor" id="rut_profesor_supervisor_prac"
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                               placeholder="Ej: 12345678-9" value="{{ old('rut_profesor_supervisor') }}"
                               minlength="8" maxlength="10">
                    </div>
                </div>

                <!-- Campo Semestre -->
                <div>
                    <label for="semestre_inicio" class="block text-sm font-semibold text-gray-700 mb-1">Semestre Inicio (opcional)</label>
                    <input type="text" name="semestre_inicio" id="semestre_inicio"
                           class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition"
                           value="{{ old('semestre_inicio') }}" placeholder="Ej: 2026-1">
                </div>

                <!-- Botón de Guardar -->
                <div class="pt-2 content-flex justify-between flex">
                    <button type="submit" 
                            class="w-full sm:w-auto px-6 py-2.5 bg-[#dd120b] hover:bg-red-700 text-white font-semibold rounded-lg text-sm transition duration-150 shadow-md cursor-pointer">
                        Guardar Habilitación
                    </button>
                     <a href="{{ route('home') }}" 
                   class="inline-flex justify-end px-3.5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition duration-150 shadow-xs">
                    ← Atrás
                </a>
                </div>

            </form>
        </div>
    </main>

    <!-- Script de lógica dinámicas -->
    <script>
        const tipoSelect = document.getElementById('tipo_HabilProf');
        const grupoProyecto = document.getElementById('grupoProyecto');
        const grupoPractica = document.getElementById('grupoPractica');

        function setGroupEnabled(groupEl, enabled) {
            groupEl.style.display = enabled ? 'block' : 'none';
            groupEl.querySelectorAll('input, textarea, select').forEach(el => {
                el.disabled = !enabled;
                el.removeAttribute('required');
            });
        }

        function updateUI() {
            const v = tipoSelect.value;

            if (v === 'Pring' || v === 'Prinv') {
                setGroupEnabled(grupoProyecto, true);
                setGroupEnabled(grupoPractica, false);
                const supProj = document.getElementById('rut_profesor_supervisor_proj');
                if (supProj) supProj.setAttribute('required', 'required');
            } else if (v === 'PrTut') {
                setGroupEnabled(grupoProyecto, false);
                setGroupEnabled(grupoPractica, true);
                const supPrac = document.getElementById('rut_profesor_supervisor_prac');
                if (supPrac) supPrac.setAttribute('required', 'required');
            } else {
                setGroupEnabled(grupoProyecto, false);
                setGroupEnabled(grupoPractica, false);
            }
        }

        tipoSelect.addEventListener('change', updateUI);
        window.addEventListener('load', updateUI);
    </script>
</body>
</html>
@endsection