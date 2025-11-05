@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h4>Listado Histórico de Habilitaciones</h4>

        <form action="{{ route('habilitaciones.HistoricoResultados') }}" method="POST">
            @csrf

            <div class="mb-3 col-md-3">
                <label for="semestre_inicio" class="form-label">Semestre inicio (ej: 2023-1)</label>
                <input type="text" name="semestre_inicio" id="semestre_inicio"
                    class="form-control @error('semestre_inicio') is-invalid @enderror" value="{{ old('semestre_inicio') }}"
                    required pattern="^(199[0-9]|20[0-3][0-9]|204[0-5])-(1|2)$"
                    title="Debe tener el formato AAAA-S, con año entre 1990 y 2045, y S igual a 1 o 2.">

                @error('semestre_inicio')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="solo_semestre" id="solo_semestre" class="form-check-input">
                <label for="solo_semestre" class="form-check-label">
                    Ver sólo resultados para este semestre
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>
    </div>
@endsection