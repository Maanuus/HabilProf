@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Listado Histórico de Habilitaciones</h4>
    <form action="{{ route('habilitaciones.HistoricoResultados') }}" method="POST">
        @csrf
        <div class="mb-3 col-md-3">
            <label for="semestre_inicio" class="form-label">Semestre inicio (ej: 2023-1)</label>
            <input type="text" name="semestre_inicio" id="semestre_inicio" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
</div>
@endsection
