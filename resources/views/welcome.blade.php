<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/ucsc_icon.png') }}" type="image/x-icon">
    <title>UCSC - HabilProf</title>

   
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  

<body class= "bg-gray-100 font-sans text-gray-800 min-h-screen flex flex-col ">
    <!-- Header -->
    <header class="bg-[#dd120b] text-white shadow-md" >
        <div class= "w-full mx-auto px-6 py-3 flex items-center justify-between">

            <div class ="shrink-0">
                <img src="{{ asset('images/ucsc_logo.png') }}" alt="UCSC Logo" class="w-44 h-auto block">
            </div>
     

            <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.panel') }}" 
                        class="inline-flex items-center px-3 py-1.5 bg-white/10 hover:bg-white/20 text-white rounded-lg text-sm font-medium duration-150">
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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
        
        @include('partials._sync_notification')

        <!-- Título -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Gestión de Habilitaciones Profesionales</h1>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-xs border border-gray-200 border-l-4 border-l-[#404041] p-5">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Habilitaciones Activas</span>
                <div class="text-2xl font-extrabold text-gray-900 mt-1">📊 {{ $total }}</div>
            </div>
        
            <div class="bg-white rounded-xl shadow-xs border border-gray-200 border-l-4 border-l-[#404041] p-5">
                <span class="font-mono text-l font-semibold text-gray-500 uppercase tracking-wider">Proyecto Ingeniería</span>
                <div class="text-2xl font-extrabold text-gray-900 mt-1">🔧 {{$countPring}}</div>
            </div>

            <div class="bg-white rounded-xl shadow-md
            s border border-gray-200 border-l-4 border-l-[#404041] p-5">
                <span class="font-mono text-l font-semibold text-gray-500 uppercase tracking-wider">Proyecto Investigación</span>
                <div class="text-2xl font-extrabold text-gray-900 mt-1">📚 {{$countPrinv}}</div>
            </div>

</main>
    <div class="container-fluid">
        <div class="col-md-9 col-lg-10 p-4">
            @include('partials._sync_notification')

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Gestión de Habilitaciones Profesionales</h4>
            </div>

            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card stats-card h-100">
                        <div class="card-body">
                            <h5 class="card-title">📊 {{ $total }}</h5>
                            <p class="card-text">Habilitaciones Activas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stats-card h-100">
                        <div class="card-body">
                            <h5 class="card-title">🔧 {{$countPring}}</h5>
                            <p class="card-text">Proyecto Ingeniería</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stats-card h-100">
                        <div class="card-body">
                            <h5 class="card-title">📚 {{$countPrinv}}</h5>
                            <p class="card-text">Proyecto Investigación</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stats-card h-100">
                        <div class="card-body">
                            <h5 class="card-title">👥 {{$countPrTut}}</h5>
                            <p class="card-text">Práctica Tutelada</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex mb-4">
                <a href="{{ route('habilitaciones.create') }}" class="btn btn-primary me-2">
                    <i class="bi bi-plus-circle"></i> Nueva habilitación
                </a>
                <a href="{{ route('habilitaciones.FormularioSemestral') }}" class="btn btn-primary me-2">
                    <i class="bi bi-list-ul"></i> Listados Habilitación
                </a>
                <a href="{{ route('habilitaciones.FormularioProfesor') }}" class="btn btn-primary">
                    <i class="bi bi-list-ul"></i> Listado Habilitaciones por Profesor
                </a>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-table me-2"></i>Últimas 5 Habilitaciones Registradas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>RUT Alumno</th>
                            <th>Nombre Alumno</th>
                            <th>Modalidad</th>
                            <th>Semestre</th>
                            <th>Nota</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ultimas as $h)
                            <tr>
                                <td>{{ $h->rut_Alumno }}-{{ $h->DV }}</td>
                                <td>{{ $h->nombre_Alumno }}</td>
                                <td>{{ $h->tipo_HabilProf }}</td>
                                <td>{{ $h->semestre_inicio }}</td>
                                <td>{{ $h->nota ?? '-' }}</td>
                                <td>{{ $h->descripcion ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay habilitaciones recientes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>