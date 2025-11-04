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
                <div class="col-auto">
                    <span class="me-3"><i class="bi bi-person-circle"></i> Admin_DINF</span>
                    <button class="btn btn-sm btn-outline-light">Salir</button>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Gestión de Habilitaciones Profesionales</h4>
            </div>

            <!-- Stats Cards -->
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

            <!-- Search and Actions -->
            <div class="row mb-4">
                <div class="col-auto p-0 me-2">
                    <a href="{{ route('habilitaciones.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nueva habilitación
                    </a>
                </div>
                <div class="col-auto p-0">
                    <a href="{{ route('habilitaciones.HistoricoForm') }}" class="btn btn-primary">
                        <i class="bi bi-list-ul"></i> Listados Habilitación
                    </a>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-table me-2"></i>Habilitaciones Registradas</h6>
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
                                <th>Acciones</th> {{-- nueva columna --}}
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

                                    <td>
                                        <!-- Botón Editar -->
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <!-- Botón Eliminar -->
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </td>
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
    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>