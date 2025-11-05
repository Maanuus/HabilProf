@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Listado de Habilitaciones por Profesor</h4>
        <a href="{{ route('habilitaciones.ProfesorForm') }}" class="btn btn-secondary">← Atrás</a>
    </div>

    <h6>Resultados {{ $solo_semestre ? 'del semestre' : 'desde el semestre' }} {{ $semestre_inicio }}</h6>
    <p><strong>Profesor:</strong> {{ $rut_Profesor }}</p>

    @if ($habilitaciones->isEmpty())
        <div class="alert alert-warning mt-3">
            No se encontraron habilitaciones para los criterios ingresados.
        </div>
    @else
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>RUT Alumno</th>
                    <th>Tipo Habilitación</th>
                    <th>Semestre Inicio</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($habilitaciones as $h)
                    <tr>
                        <td>{{ $h->nombre_Alumno }}</td>
                        <td>{{ $h->rut_Alumno }}</td>
                        <td>{{ $h->tipo_HabilProf }}</td>
                        <td>{{ $h->semestre_inicio }}</td>
                        <td>{{ $h->nota }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
