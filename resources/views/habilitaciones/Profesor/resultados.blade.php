@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if($resultados->isEmpty())
        <p>No se encontraron habilitaciones para este profesor.</p>
    @else
        @php
            $nombreProfesor = $resultados->first()->first()->nombre_Profesor ?? '';
        @endphp
     
        <h3>Historial de Habilitaciones Profesor: <strong>{{ $nombreProfesor }}</strong></h3>
         
        @foreach($resultados as $tipo => $habilitaciones)
            <div class="card my-4">
                <div class="card-header bg-primary text-white">
                    {{ $tipo }}
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>RUT Alumno</th>
                                <th>Nombre Alumno</th>
                                <th>Tipo Habilitación</th>
                                <th>Semestre Inicio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($habilitaciones as $h)
                                <tr>
                                    <td>{{ $h->rut_Alumno }}</td>
                                    <td>{{ $h->nombre_Alumno }}</td>
                                    <td>{{ $h->tipo_HabilProf }}</td>
                                    <td>{{ $h->semestre_inicio }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
    <a href="{{ route('habilitaciones.ProfesorForm') }}" class="btn btn-secondary">
                ← Atrás
            </a>
</div>

@endsection
