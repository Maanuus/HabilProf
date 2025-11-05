@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Listado Histórico de Habilitaciones</h4>
            <a href="{{ route('habilitaciones.HistoricoForm') }}" class="btn btn-secondary">
                ← Atrás
            </a>
        </div>

        <h6>Resultados {{ $solo_semestre ? 'del semestre' : 'desde el semestre' }} {{ $semestre_inicio }}</h6>

        @if ($habilitaciones->isEmpty())
            <div class="alert alert-warning mt-3">
                No se encontraron habilitaciones para el semestre indicado.
            </div>
        @else
            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>RUT</th>
                        <th>Nombre</th>
                        <th>Tipo Habilitación</th>
                        <th>Semestre Inicio</th>
                        <th>Nota</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($habilitaciones as $h)
                        <tr>
                            {{-- RUT completo con DV --}}
                            <td>{{ $h->rut_Alumno }}-{{ $h->DV }}</td>
                            <td>{{ $h->nombre_Alumno }}</td>
                            <td>{{ $h->tipo_HabilProf }}</td>
                            <td>{{ $h->semestre_inicio }}</td>
                            <td>{{ $h->nota }}</td>
                            <td>{{ $h->descripcion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection