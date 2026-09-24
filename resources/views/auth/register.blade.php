<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro | HabilProf</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/ucsc_icon.png') }}" type="image/x-icon">

    <!-- Carga de Tailwind CSS mediante Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cover bg-center bg-no-repeat min-h-screen font-sans antialiased relative" 
      style="background-image: url('{{ asset('images/Campus-San-Andres-UCSC.jpg') }}');">

    <!-- Overlay oscuro -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>

    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            
            <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 p-6 sm:p-8">
                
                <div class="text-center mb-6">
                    <div class="flex justify-center">
                        <img src="{{ asset('images/ucsc_logo_color.png') }}" alt="Logo UCSC" class="w-48 h-auto">
                    </div>
                    <h1 class="text-xl font-bold mt-4 text-gray-800">Crear Cuenta</h1>
                    <div class="text-gray-500 text-sm font-medium">HabilProf</div>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-xs">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nombre Completo</label>
                        <input name="name" id="name" type="text" 
                               value="{{ old('name') }}"
                               placeholder="Primer nombre y dos apellidos" 
                               class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition shadow-xs" required>
                    </div>

                    <div>
                        <label for="rut" class="block text-sm font-semibold text-gray-700 mb-1">RUT</label>
                        <input name="rut" id="rut" type="text" 
                               value="{{ old('rut') }}"
                               placeholder="12.345.678-K" 
                               class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition shadow-xs" required>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
                        <input name="password" id="password" type="password" 
                               placeholder="Mínimo 8 caracteres" 
                               class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition shadow-xs" required>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar Contraseña</label>
                        <input name="password_confirmation" id="password_confirmation" type="password" 
                               placeholder="Repite la contraseña" 
                               class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#dd120b] transition shadow-xs" required>
                    </div>

                    <button type="submit" 
                            class="w-full bg-[#dd120b] hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-lg text-sm transition duration-150 shadow-md cursor-pointer mt-2">
                        Registrarme
                    </button>

                    <div class="text-xs text-gray-600 text-center pt-2">
                        ¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="text-[#dd120b] font-semibold hover:underline">Inicia sesión aquí</a>
                    </div>
                </form>
            </div>

            <div class="text-center mt-6">
                <span class="bg-black/20 backdrop-blur-xs text-gray-200 text-xs px-3 py-1 rounded-full border border-white/10 shadow-sm">
                    © {{ date('Y') }} HabilProf
                </span>
            </div>

        </div>
    </div>
</body>
</html>
