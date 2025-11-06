<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Nueva habilitación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 (CDN) -->
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
                                    <label class="form-label">RUT Alumno </label>
                                    <input type="text" name="rut" class="form-control" placeholder="Ej: Sin puntos, con Dígito Verificador" value="{{ old('rut') }}" required>
                                </div>

                                <div class="col-md-7">
                                    <label class="form-label">Nombre Alumno</label>
                                    <input type="text" name="nombre_alumno" class="form-control" placeholder="Nombre Completo" value="{{ old('nombre_alumno') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Carrera</label>
                                    <input type="text" name="carrera" class="form-control" placeholder="Ej: Ingeniería Civil" value="{{ old('carrera') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Correo Alumno</label>
                                    <input type="email" name="correo_alumno" class="form-control" placeholder="Ej: maria@ing.ucsc.cl" value="{{ old('correo_alumno') }}" required>
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
                                    <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}">

                                    <label class="mt-2">Descripción</label>
                                    <textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>

                                    <label class="mt-2">RUT Profesor Comisión</label>
                                    <input type="text" name="rut_profesor_comision" class="form-control" value="{{ old('rut_profesor_comision') }}">

                                    <label class="mt-2">RUT Profesor Co-guía (opcional)</label>
                                    <input type="text" name="rut_profesor_coguia" class="form-control" value="{{ old('rut_profesor_coguia') }}">
                                </div>

                                <!-- Datos PrTut -->
                                <div id="grupoPractica" class="col-12 mt-3" style="display:none;">
                                    <label>Nombre Empresa</label>
                                    <input type="text" name="nombre_Empresa" class="form-control" value="{{ old('nombre_Empresa') }}">

                                    <label class="mt-2">Nombre Supervisor Empresa</label>
                                    <input type="text" name="nombre_Supervisor" class="form-control" value="{{ old('nombre_Supervisor') }}">
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label>Semestre Inicio (puede quedar vacío)</label>
                                    <input type="text" name="semestre_inicio" class="form-control" value="{{ old('semestre_inicio') }}" placeholder="Ej: 2025-1">
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

        tipoSelect.addEventListener('change', function() {
            if(this.value === 'Pring' || this.value === 'Prinv'){
                grupoProyecto.style.display = 'block';
                grupoPractica.style.display = 'none';
            } else if(this.value === 'PrTut'){
                grupoProyecto.style.display = 'none';
                grupoPractica.style.display = 'block';
            } else {
                grupoProyecto.style.display = 'none';
                grupoPractica.style.display = 'none';
            }
        });

        // Mostrar grupo correcto si hay old()
        window.addEventListener('load', function() {
            const tipo = tipoSelect.value;
            if(tipo === 'Pring' || tipo === 'Prinv') grupoProyecto.style.display = 'block';
            if(tipo === 'PrTut') grupoPractica.style.display = 'block';
        });
    </script>
    @endsection
</body>
</html>
