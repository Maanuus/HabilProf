<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/ucsc_icon.png') }}" type="image/x-icon">
    <title>UCSC - Formulario Semestral</title>

    <!-- Carga de Tailwind CSS y JS mediante Vite (AQUÍ DENTRO DEL HEAD) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-800 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-[#dd120b] text-white shadow-md">
        <div class="w-full px-6 py-3 flex items-center justify-between">
            <div class="shrink-0">
                <img src="{{ asset('images/ucsc_logo.png') }}" alt="UCSC Logo" class="w-44 h-auto block">
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.panel') }}" 
                   class="inline-flex items-center px-3.5 py-1.5 bg-white/10 hover:bg-white/20 text-white rounded-lg text-sm font-medium transition duration-150">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.532 1.532 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.532 1.532 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                    Admin
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="px-3.5 py-1.5 bg-white text-gray-800 hover:bg-gray-200 text-sm font-semibold transition duration-150 shadow-xs cursor-pointer rounded-lg">
                        Salir
                    </button>
                </form>
            </div>
        </div>
    </header>

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
                        class="w-full px-3.5 py-2 border @error('semestre_inicio') border-red-500 @else border-gray-300 @enderror rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition" 
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

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-4 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-gray-500">
            © {{ date('Y') }} HabilProf — Universidad Católica de la Santísima Concepción
        </div>
    </footer>
</body>
</html>