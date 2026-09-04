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
<body class="bg-cover bg-center bg-no-repeat min-h-screen font-sans antialiased relative" 
      style="background-image: url('{{ asset('images/Campus-San-Andres-UCSC.jpg') }}');">

    <!-- Capa de oscurecimiento (Overlay) para mejorar el contraste general -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>

    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            
            <!-- Tarjeta principal con fondo semitransparente sólido -->
            <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 p-6 sm:p-8">
                
                <!-- Encabezado / Logo -->
                <div class="text-center mb-6">
                    <div class="flex justify-center">
                        <img src="{{ asset('images/ucsc_logo_color.png') }}" alt="Logo UCSC" width="190" class="w-48 h-auto">
                    </div>
                    <h1 class="text-xl font-bold mt-4 text-gray-800">Portal de Ingreso</h1>
                    <div class="text-gray-500 text-sm font-medium">HabilProf</div>
                </div>

                <!-- Formulario -->
                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf
                    
                    <!-- Campo RUT -->
                    <div>
                        <label for="rut" class="block text-sm font-semibold text-gray-700 mb-1">RUT</label>
                        <input name="rut" id="rut" type="text" 
                            value="{{ old('rut') }}"
                            placeholder="12.345.678-K" 
                            class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#dd120b] focus:border-transparent transition shadow-xs">
                    </div>

                    <!-- Campo Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
                        <input name="password" id="password" type="password" 
                            placeholder="********" 
                            class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#dd120b] focus:border-transparent transition shadow-xs">
                    </div>

                    <!-- Botón de Submit -->
                    <button type="submit" 
                            class="w-full bg-[#dd120b] hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-lg text-sm transition duration-150 ease-in-out shadow-md cursor-pointer">
                        Ingresa
                    </button>

                    <div class="text-xs text-gray-500 text-center pt-2">
                        ¿No tienes acceso o olvidaste tu clave? <br>
                        <span class="text-gray-600 font-medium">Contacta a la Jefatura de Carrera.</span>
                    </div>

                    <!-- Error de validación -->
                    @error('rut')
                        <div class="text-red-600 text-xs font-semibold mt-2 text-center bg-red-50 p-2 rounded-md border border-red-200">
                            {{ $message }}
                        </div>
                    @enderror
                </form>
            </div>

            <!-- Footer con contraste protegido -->
            <div class="text-center mt-6">
                <span class="bg-black/20 backdrop-blur-xs text-gray-200 text-xs px-3 py-1 rounded-full border border-white/10 shadow-sm">
                    © {{ date('Y') }} HabilProf
                </span>
            </div>

        </div>
    </div>
</body>
</html>