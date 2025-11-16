@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Filtrar habilitaciones por profesor</h2>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('habilitaciones.ResultadoProfesor') }}" method="POST"  >
        @csrf

        <div class="row mb-3">
          
            <div class="col-md-3">
                <label for="rut_profesor" class="form-label">RUT Profesor</label>
                <input 
                    type="text" 
                    name="rut_profesor" 
                    id="rut_profesor" 
                    class="form-control @error('rut_profesor') is-invalid @enderror"
                    value="{{ old('rut_profesor') }}"
                    required 
                    pattern="^[1-9][0-9]{6,7}$"
                    title="El RUT debe ser un número entero de 7 u 8 dígitos">

               
                @error('rut_profesor')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
           
            <div class="col-md-1">
                <label for="dv" class="form-label">DV</label>
                <input 
                    type="text" 
                    name="dv" 
                    id="dv" 
                    maxlength="1" 
                    class="form-control text-center @error('dv') is-invalid @enderror"
                    value="{{ old('dv') }}"
                    required 
                    pattern="^[0-9Kk]$"
                    title="El dígito verificador debe ser un número o la letra K.">

           
                @error('dv')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

    
        <div class="mb-3 col-md-3">
            <label for="semestre_inicio" class="form-label">Semestre (ej: 2023-1)</label>
            <input 
                type="text" 
                name="semestre_inicio" 
                id="semestre_inicio"
                class="form-control @error('semestre_inicio') is-invalid @enderror"
                value="{{ old('semestre_inicio') }}"
                required 
                pattern="^(199[0-9]|20[0-3][0-9]|204[0-5])-(1|2)$"
                title="Debe tener el formato AAAA-S, con año entre 1990 y 2045, y S igual a 1 o 2.">

       
            @error('semestre_inicio')
            <div class="invalid-feedback">{{ $message }}</div>
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
