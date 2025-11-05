@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Filtrar habilitaciones por profesor</h2>
    <form action="{{ route('habilitaciones.profesor.resultados') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="rut_profesor" class="form-label">RUT Profesor (sin DV)</label>
            <input type="number" name="rut_profesor" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="dv" class="form-label">Dígito Verificador</label>
            <input type="text" name="dv" maxlength="1" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="semestre_inicio" class="form-label">Desde semestre</label>
            <input type="text" name="semestre_inicio" placeholder="2023-1" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
</div>
@endsection
