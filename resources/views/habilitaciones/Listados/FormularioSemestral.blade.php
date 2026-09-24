@extends('layouts.app')

@section('title', 'UCSC - Formulario Semestral')
@section('content')
<body class="bg-gray-100 font-sans text-gray-800 min-h-screen flex flex-col">


    <!-- Contenido Principal -->
    <main class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full grow">
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 sm:p-8">
            
            <!-- Encabezado de la tarjeta -->
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-900">Listado Histórico de Habilitaciones</h1>
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

            <!-- Formulario de Filtro -->
            <form action="{{ route('habilitaciones.ResultadoSemestral') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Campo Semestre Inicio -->
                <div>
                    <label for="semestre_inicio" class="block text-sm font-semibold text-gray-700 mb-1">
                        Semestre inicio
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
                        <p class="mt-1 text-xs text-red-600 font-medium">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Checkbox Solo Semestre -->
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

                <!-- Botones de Acción -->
                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-between gap-3 border-t border-gray-100">
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