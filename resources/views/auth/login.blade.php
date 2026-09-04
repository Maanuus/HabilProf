<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Login | HabilProf</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/ucsc_icon.png') }}" type="image/x-icon">

    <!-- Carga de Tailwind CSS a través de Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f5f7fb] font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            
            <!-- Tarjeta principal -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                
                <!-- Encabezado / Logo -->
                <div class="text-center mb-6 ">
                    <div class="flex justify-center">
                        <img src="{{ asset('images/ucsc_logo_color.png') }}" alt="Logo" class="w-50 h-auto">
                    </div>
                    <h1 class="text-lg font-bold mt-4 mb-0 text-gray-800">Portal de Ingreso</h1>
                    <div class="text-gray-500 text-sm">HabilProf</div>
                </div>

                <!-- Formulario -->
                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf
                    
                    <!-- Campo RUT -->
                    <div>
                        <label for="rut" class="block text-sm font-semibold text-gray-700 mb-1">RUT</label>
                        <input name="rut" id="rut" type="text" 
                               value="{{ old('rut') }}"
                               placeholder="Ej: 12.345.678-K" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#dd120b] focus:border-transparent transition">
                    </div>

                    <!-- Campo Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
                        <input name="password" id="password" type="password" 
                               placeholder="********" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#dd120b] focus:border-transparent transition">
                    </div>

                    <!-- Botón de Submit -->
                    <button type="submit" 
                            class="w-full bg-[#dd120b] hover:bg-red-700 text-white font-medium py-2.5 px-4 rounded-lg text-sm transition duration-150 ease-in-out shadow-sm cursor-pointer">
                        Ingresa
                    </button>

                    <!-- Error de validación -->
                    @error('rut')
                        <div class="text-red-600 text-xs font-medium mt-2 text-center">{{ $message }}</div>
                    @enderror
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-4 text-gray-400 text-xs">
                © {{ date('Y') }} HabilProf
            </div>

        </div>
    </div>
</body>
</html>