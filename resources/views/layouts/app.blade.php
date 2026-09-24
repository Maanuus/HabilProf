<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/ucsc_icon.png') }}" type="image/x-icon">
    <title>@yield('title', 'UCSC - HabilProf')</title>

    <!-- Tailwind CSS 4 y JS mediante Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-800 min-h-screen flex flex-col antialiased">

    <!-- Header Institucional UCSC -->
    <header class="bg-[#dd120b] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <div class="shrink-0 flex items-center space-x-3">
                <a href="{{ route('home') }}" class="block">
                    <img src="{{ asset('images/ucsc_logo.png') }}" alt="Logo UCSC" class="w-40 sm:w-44 h-auto block">
                </a>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-3">
                @auth
                    <a href="{{ route('admin.panel') }}" 
                    class="inline-flex items-center px-3 py-1.5 bg-white/10 hover:bg-white/20 text-white rounded-lg text-xs sm:text-sm font-medium transition duration-150">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.532 1.532 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.532 1.532 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                        Admin
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="px-3 py-1.5 bg-white text-gray-800 hover:bg-gray-100 text-xs sm:text-sm font-semibold rounded-lg shadow-xs transition duration-150 cursor-pointer">
                            Salir
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3.5 py-1.5 bg-white text-gray-800 hover:bg-gray-100 text-xs sm:text-sm font-semibold rounded-lg shadow-xs transition duration-150">
                        Ingresar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Contenedor Principal -->
    <main class="w-full grow py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('partials._sync_notification')
            @yield('content')
        </div>
    </main>

    <!-- Footer Institucional -->
    <footer class="bg-white border-t border-gray-200 py-4 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-gray-500">
            © {{ date('Y') }} HabilProf — Universidad Católica de la Santísima Concepción
        </div>
    </footer>

    @stack('scripts')
</body>
</html>