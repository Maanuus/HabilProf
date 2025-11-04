<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar habilitación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/ucsc_icon.png') }}" type="image/x-icon">

    <style>
        .ucsc-header { background-color: #dd120bff; color: white; }
        .stats-card { border-left: 4px solid #0056b3; }
        .sync-status { font-size: 0.8rem; }
        .nav-link { color: #495057; }
        .nav-link:hover { background-color: #e9ecef; }
    </style>
</head>
<body class="bg-light">
    <!-- Header -->
    <header class="ucsc-header py-2">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/ucsc_logo.png') }}" alt="Logo" width="180">
                        </a>
                    </h4>
                </div>
                <div class="col-auto">
                    <span class="me-3"><i class="bi bi-person-circle"></i> Admin_DINF</span>
                    <a class="btn btn-sm btn-outline-light" href="{{ route('home') }}">Salir</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h4 mb-4">Editar habilitación</h1>

                        <form action="{{ route('habilitaciones.update', $habilitacion['id_habilitacion']) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold">RUT</label>
                                    <input name="rut" value="{{ old('rut', $habilitacion['rut']) }}" class="form-control" placeholder="Sin puntos y con número verificador" required>
                                </div>

                                <div class="col-md-7">
                                    <label class="form-label fw-semibold">Nombre Alumno</label>
                                    <input name="nombre_alumno" value="{{ old('nombre_alumno', $habilitacion['nombre_alumno']) }}" class="form-control" placeholder="Nombre Completo" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Carrera</label>
                                    <input name="carrera" value="{{ old('carrera', $habilitacion['carrera']) }}" class="form-control" placeholder="Ej: Ingeniería Civil" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Correo Alumno</label>
                                    <input name="correo_alumno" value="{{ old('correo_alumno', $habilitacion['correo_alumno']) }}" class="form-control" placeholder="Ej: alumno@ing.ucsc.cl" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">ID habilitación</label>
                                    <input name="id_habilitacion" value="{{ old('id_habilitacion', $habilitacion['id_habilitacion']) }}" class="form-control" placeholder="ID de la habilitación" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tipo de habilitación profesional</label>
                                    <select name="tipo_HabilProf" id="tipo_HabilProf" class="form-select" required>
                                        <option value="" disabled>Seleccione un tipo</option>
                                        <option value="PrIng" {{ old('tipo_HabilProf', $habilitacion['tipo_HabilProf']) === 'PrIng' ? 'selected' : '' }}>Proyecto Ingeniería</option>
                                        <option value="PrInv" {{ old('tipo_HabilProf', $habilitacion['tipo_HabilProf']) === 'PrInv' ? 'selected' : '' }}>Proyecto Investigación</option>
                                        <option value="PrTut" {{ old('tipo_HabilProf', $habilitacion['tipo_HabilProf']) === 'PrTut' ? 'selected' : '' }}>Práctica Tutelada</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Grupo Proyecto (PrIng/PrInv) -->
                            @php $isProyecto = in_array(old('tipo_HabilProf', $habilitacion['tipo_HabilProf']), ['PrIng','PrInv']); @endphp
                            <div id="grupoProyecto" class="mt-4" {{ $isProyecto ? '' : 'hidden' }}>
                                <hr class="my-3">
                                <h2 class="h6 mb-3">Datos de proyecto (PrIng/PrInv)</h2>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Título</label>
                                        <input name="titulo" id="titulo" class="form-control" maxlength="100"
                                               placeholder="Solo letras y espacios (Máx. 100 carácteres)"
                                               value="{{ old('titulo', $habilitacion['titulo']) }}"
                                               pattern="^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ ]{1,100}$">
                                        <div class="invalid-feedback">Título inválido.</div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Descripción</label>
                                        <textarea name="descripcion" id="descripcion" class="form-control" rows="4" maxlength="500"
                                                  placeholder="Solo letras y espacios (máx 500)">{{ old('descripcion', $habilitacion['descripcion']) }}</textarea>
                                        <div class="invalid-feedback">Descripción requerida.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">RUT Profesor Comisión (obligatorio)</label>
                                        <input name="rut_profesor_comision" id="rut_profesor_comision" class="form-control"
                                               placeholder="Sin puntos y con número verificador" pattern="^\d{7,8}-[\dkK]$"
                                               value="{{ old('rut_profesor_comision', $habilitacion['rut_profesor_comision']) }}">
                                        <div class="invalid-feedback">RUT inválido u omitido.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">RUT Profesor Co-guía (opcional)</label>
                                        <input name="rut_profesor_coguia" id="rut_profesor_coguia" class="form-control"
                                               placeholder="Sin puntos y con número verificador" pattern="^\d{7,8}-[\dkK]$"
                                               value="{{ old('rut_profesor_coguia', $habilitacion['rut_profesor_coguia']) }}">
                                        <div class="invalid-feedback">RUT inválido.</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Semestre de inicio</label>
                                        <input name="semestre_inicio" id="semestre_inicio" class="form-control" placeholder="AAAA-S"
                                               value="{{ old('semestre_inicio', $habilitacion['semestre_inicio']) }}"
                                               pattern="^(1990|199[1-9]|20[0-3][0-9]|204[0-5])-[12]$">
                                        <div class="invalid-feedback">Formato inválido (ej: 2025-1).</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Grupo Práctica (PrTut) -->
                            @php $isPractica = old('tipo_HabilProf', $habilitacion['tipo_HabilProf']) === 'PrTut'; @endphp
                            <div id="grupoPractica" class="mt-4" {{ $isPractica ? '' : 'hidden' }}>
                                <hr class="my-3">
                                <h2 class="h6 mb-3">Datos de práctica (PrTut)</h2>

                                <div class="row g-3">
                                    <div class="col-md-7">
                                        <label class="form-label fw-semibold">Nombre Empresa</label>
                                        <input name="nombre_Empresa" id="nombre_Empresa" class="form-control" maxlength="100"
                                               placeholder="Solo letras y espacios (Máx. 100 carácteres)"
                                               value="{{ old('nombre_Empresa', $habilitacion['nombre_Empresa']) }}"
                                               pattern="^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ ]{1,100}$">
                                        <div class="invalid-feedback">Nombre inválido.</div>
                                    </div>

                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold">Nombre Supervisor</label>
                                        <input name="nombre_Supervisor" id="nombre_Supervisor" class="form-control" maxlength="80"
                                               placeholder="Solo letras y espacios (Máx. 80 carácteres)"
                                               value="{{ old('nombre_Supervisor', $habilitacion['nombre_Supervisor']) }}"
                                               pattern="^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ ]{1,80}$">
                                        <div class="invalid-feedback">Nombre inválido.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Editar datos</button>
                            </div>
                        </form>

                        <div class="alert alert-info mt-3 mb-0">
                            Mockup: Al editar los datos se va a la página principal con mensaje.
                        </div>
                    </div>
                </div>

                <div class="text-muted small text-center mt-3">
                    © {{ date('Y') }} HabilProf
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Reutiliza tu JS si ya maneja el toggle -->
    <script src="{{ asset('js/habilitaciones.create.js') }}"></script>

    <!-- Fallback mínimo por si no cargas el JS anterior -->
    <script>
      (function () {
        const tipo = document.getElementById('tipo_HabilProf');
        const gp = document.getElementById('grupoProyecto');
        const gt = document.getElementById('grupoPractica');
        function toggle() {
          const v = tipo.value;
          gp.hidden = !(v === 'PrIng' || v === 'PrInv');
          gt.hidden = !(v === 'PrTut');
        }
        if (tipo) {
          tipo.addEventListener('change', toggle);
          toggle(); // estado inicial
        }
      })();
    </script>
</body>
</html>
