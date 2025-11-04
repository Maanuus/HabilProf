@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Resultados desde el semestre: {{ $semestre_inicio }}</h4>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>RUT Alumno</th>
                <th>Nombre</th>
                <th>Modalidad</th>
                <th>Semestre</th>
                <th>Nota</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($habilitaciones as $h)
            <tr>
                <td>{{ $h->rut_Alumno }}-{{ $h->DV }}</td>
                <td>{{ $h->nombre_Alumno }}</td>
                <td>{{ $h->tipo_HabilProf }}</td>
                <td>{{ $h->semestre_inicio }}</td>
                <td>{{ $h->nota ?? '-' }}</td>
                <td>{{ $h->descripcion ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
