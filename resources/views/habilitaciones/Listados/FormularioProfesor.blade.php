@extends('layouts.app')

@section('title', 'UCSC - Filtrar Habilitaciones por Profesor')
@section('content')
<body class="bg-gray-100 font-sans text-gray-800 min-h-screen flex flex-col">

    <!-- Contenido Principal -->
    <main class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full grow">
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 sm:p-8">
            
            <!-- Encabezado de la tarjeta -->
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-900">Filtrar Habilitaciones por Profesor</h1>
            </div>

            <!-- Alerta de Errores Globales -->
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
            <form action="{{ route('habilitaciones.ResultadoProfesor') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Fila de RUT y DV -->
                <div class="grid grid-cols-12 gap-4">
                    <!-- Campo RUT -->
                    <div class="col-span-9 sm:col-span-10">
                        <label for="rut_profesor" class="block text-sm font-semibold text-gray-700 mb-1">
                            RUT Profesor
                        </label>
                        <input 
                            type="text" 
                            name="rut_profesor" 
                            id="rut_profesor"
                            @class([
                                'w-full px-3.5 py-2 border rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition',
                                'border-red-500' => $errors->has('rut_profesor'),
                                'border-gray-300' => !$errors->has('rut_profesor'),
                            ])
                            value="{{ old('rut_profesor') }}" 
                            placeholder="Ej: 12345678"
                            required 
                            pattern="^([5-9][0-9]{6}|[1-9][0-9]{7})$"
                            title="El RUT debe estar entre 5.000.000 y 99.999.999"
                        >
                        @error('rut_profesor')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campo DV -->
                    <div class="col-span-3 sm:col-span-2">
                        <label for="dv" class="block text-sm font-semibold text-gray-700 mb-1 text-center">
                            DV
                        </label>
                        <input 
                            type="text" 
                            name="dv" 
                            id="dv"
                            maxlength="1"
                            @class([
                                'w-full px-2 py-2 border text-center rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] uppercase transition',
                                'border-red-500' => $errors->has('dv'),
                                'border-gray-300' => !$errors->has('dv'),
                            ])
                            value="{{ old('dv') }}" 
                            placeholder="K"
                            required 
                            pattern="^[0-9Kk]$"
                            title="El dígito verificador debe ser un número o la letra K."
                        >
                        @error('dv')
                            <p class="mt-1 text-xs text-red-600 font-medium text-center">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Campo Semestre Inicio -->
                <div>
                    <label for="semestre_inicio" class="block text-sm font-semibold text-gray-700 mb-1">
                        Semestre
                    </label>
                    <input 
                        type="text" 
                        name="semestre_inicio" 
                        id="semestre_inicio"
                        @class([
                            'w-full px-3.5 py-2 border rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition',
                            'border-red-500' => $errors->has('semestre_inicio'),
                            'border-gray-300' => !$errors->has('semestre_inicio'),
                        ])
                        value="{{ old('semestre_inicio') }}" 
                        placeholder="Ej: 2023-1"
                        required 
                        pattern="^(199[0-9]|20[0-3][0-9]|204[0-5])-(1|2)$"
                        title="Debe tener el formato AAAA-S, con año entre 1990 y 2045, y S igual a 1 o 2."
                    >
                    @error('semestre_inicio')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

          
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="solo_semestre" 
                        id="solo_semestre" 
                        class="w-4 h-4 text-[#dd120b] border-gray-300 rounded focus:ring-[#dd120b] cursor-pointer"
                    >
                    <label for="solo_semestre" class="ml-2 block text-sm text-gray-700 font-medium cursor-pointer select-none">
                        Ver sólo resultados para este semestre
                    </label>
                </div>


                <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-gray-100">
                    <button type="submit" 
                            class="w-full sm:w-auto px-6 py-2.5 bg-[#dd120b] hover:bg-red-700 text-white font-semibold rounded-lg text-sm transition duration-150 shadow-md cursor-pointer">
                        Filtrar
                    </button>

                    <a href="{{ route('home') }}" 
                       class="w-full sm:w-auto text-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition duration-150 shadow-xs">
                        ← Atrás
                    </a>
                </div>
            </form>
        </div>
    </main>


</body>
</html>
@endsection