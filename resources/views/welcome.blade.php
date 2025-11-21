<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/ucsc_icon.png') }}" type="image/x-icon">
    <title>UCSC - HabilProf</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .ucsc-header {
            background-color: #dd120bff;
            color: white;
        }

        .sidebar {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .stats-card {
            border-left: 4px solid #0056b3;
        }

        .sync-status {
            font-size: 0.8rem;
        }

        .nav-link {
            color: #495057;
        }

        .nav-link:hover {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="ucsc-header py-2">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0"><a href=""><img src="{{ asset('images/ucsc_logo.png') }}" alt="Logo" width=180></a>
                    </h4>
                </div>
                <div class="col-auto d-flex align-items-center gap-2">
                    <a href="{{ route('admin.panel') }}" class="btn btn-sm btn-light text-dark">
                        <i class="bi bi-gear-fill"></i> Admin
                    </a>
                    <div class="col-auto">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-secondary btn-sm btn-light text-dark">Salir</button>
                        </form>
                    </div>
                </div>
            </div>
    </header>

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