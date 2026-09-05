<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/ucsc_icon.png') }}" type="image/x-icon">
    <title>UCSC - Resultados Históricos</title>

    <!-- Carga de Tailwind CSS y JS mediante Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-800 min-h-screen flex flex-col">

    <!-- Header institucional -->
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full grow">
        
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
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-4 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-gray-500">
            © {{ date('Y') }} HabilProf — Universidad Católica de la Santísima Concepción
        </div>
    </footer>

</body>
</html>