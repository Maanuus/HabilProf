<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Nueva habilitación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
<body class="bg-light">
@extends('layouts.app')

@section('content')
<div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Nueva Habilitación</h4>
                            <a href="{{ route('home') }}" class="btn btn-secondary">← Atrás</a>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('habilitaciones.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label class="form-label">RUT Alumno</label>
                                    <input 
                                        type="text" 
                                        name="rut" 
                                        class="form-control" 
                                        placeholder="Ej: 12345678-9"
                                        value="{{ old('rut') }}" 
                                        minlength="8"
                                        maxlenght="9"
                                        required>
                                </div>

                                <div class="col-md-7">
                                    <label class="form-label">Nombre Alumno</label>
                                    <input type="text" 
                                        name="nombre_alumno" 
                                        class="form-control" 
                                        placeholder="Nombre Completo" 
                                        value="{{ old('nombre_alumno') }}" 
                                        maxlength="40"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Carrera</label>
                                    <input type="text" 
                                        name="carrera" 
                                        class="form-control" 
                                        placeholder="Ej: Ingeniería Civil Informática" 
                                        value="{{ old('carrera') }}" 
                                        maxlenght="50"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Correo Alumno</label>
                                    <input type="email" 
                                    name="correo_alumno" 
                                    class="form-control" 
                                    placeholder="Ej: maria@ing.ucsc.cl" 
                                    value="{{ old('correo_alumno') }}" 
                                    maxlenght="35"
                                    pattern=".+@ing.ucsc\.cl"
                                    required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">ID Habilitación</label>
                                    <input type="number" name="id_habilitacion" class="form-control" value="{{ old('id_habilitacion') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tipo Habilitación</label>
                                    <select name="tipo_HabilProf" id="tipo_HabilProf" class="form-select" required>
                                        <option value="" disabled selected>Seleccione un tipo</option>
                                        <option value="Pring" {{ old('tipo_HabilProf')=='Pring' ? 'selected':'' }}>Proyecto Ingeniería</option>
                                        <option value="Prinv" {{ old('tipo_HabilProf')=='Prinv' ? 'selected':'' }}>Proyecto Investigación</option>
                                        <option value="PrTut" {{ old('tipo_HabilProf')=='PrTut' ? 'selected':'' }}>Práctica Tutelada</option>
                                    </select>
                                </div>

                                <!-- Datos Pring / Prinv -->
                                <div id="grupoProyecto" class="col-12 mt-3" style="display:none;">
                                    <label>Título</label>
                                    <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" maxlength="100">

                                    <label class="mt-2">Descripción</label>
                                    <textarea name="descripcion" class="form-control" maxlength="500">{{ old('descripcion') }}</textarea>

                                    <div class="row g-3 mt-1">
                                        <div class="col-md-6">
                                        <label class="form-label">RUT Profesor Comisión</label>
                                        <input type="text" name="rut_profesor_comision" class="form-control"
                                                placeholder="Ej: 12345678-9" value="{{ old('rut_profesor_comision') }}"
                                                minlength="8" maxlength="10">
                                        </div>
                                        <div class="col-md-6">
                                        <label class="form-label">RUT Profesor Co-guía (opcional)</label>
                                        <input type="text" name="rut_profesor_coguia" class="form-control"
                                                placeholder="Ej: 12345678-9" value="{{ old('rut_profesor_coguia') }}"
                                                minlength="8" maxlength="10">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">RUT Profesor Supervisor</label>
                                            <input
                                                type="text"
                                                name="rut_profesor_supervisor"
                                                class="form-control"
                                                placeholder="Ej: 12345678-9"
                                                value="{{ old('rut_profesor_supervisor') }}"
                                                minlength="8"
                                                maxlength="10"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Datos PrTut -->
                                <div id="grupoPractica" class="col-12 mt-3" style="display:none;">
                                    <label>Nombre Empresa</label>
                                    <input type="text" name="nombre_Empresa" class="form-control"
                                            value="{{ old('nombre_Empresa') }}" maxlength="100">

                                    <label class="mt-2">Nombre Supervisor Empresa</label>
                                    <input type="text" name="nombre_Supervisor" class="form-control"
                                            value="{{ old('nombre_Supervisor') }}" maxlength="80">

                                    <div class="row g-3 mt-1">
                                        <div class="col-md-6">
                                        <label class="form-label">RUT Profesor Supervisor</label>
                                        <input type="text" name="rut_profesor_supervisor" class="form-control"
                                                placeholder="Ej: 12345678-9" value="{{ old('rut_profesor_supervisor') }}"
                                                minlength="8" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Semestre Inicio (puede quedar vacío)</label>
                                    <input type="text" name="semestre_inicio" class="form-control"
                                            value="{{ old('semestre_inicio') }}" placeholder="Ej: 2025-1">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Guardar Habilitación</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="text-muted small text-center mt-3">
                © {{ date('Y') }} HabilProf
            </div>
        </div>
    </div>

    <script>
        const tipoSelect = document.getElementById('tipo_HabilProf');
        const grupoProyecto = document.getElementById('grupoProyecto');
        const grupoPractica = document.getElementById('grupoPractica');

        function setGroupEnabled(groupEl, enabled) {
            groupEl.style.display = enabled ? 'block' : 'none';
            groupEl.querySelectorAll('input, textarea, select').forEach(el => {
            el.disabled = !enabled;
            el.removeAttribute('required');
            });
        }

        function updateUI() {
            const v = tipoSelect.value;

            if (v === 'Pring' || v === 'Prinv') {
            setGroupEnabled(grupoProyecto, true);
            setGroupEnabled(grupoPractica, false);
            // En proyectos
            } else if (v === 'PrTut') {
            setGroupEnabled(grupoProyecto, false);
            setGroupEnabled(grupoPractica, true);
            // En práctica
            const sup = document.querySelector('[name="rut_profesor_supervisor"]');
            if (sup) sup.setAttribute('required', 'required');
            } else {
            setGroupEnabled(grupoProyecto, false);
            setGroupEnabled(grupoPractica, false);
            }
        }

        tipoSelect.addEventListener('change', updateUI);
        window.addEventListener('load', updateUI);
    </script>

    @endsection
</body>
</html>
