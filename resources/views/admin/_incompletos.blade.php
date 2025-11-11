@if($alumnosIncompletos->count() === 0 && $profesoresIncompletos->count() === 0)
    <div class="alert alert-success">No hay datos incompletos en alumnos ni profesores.</div>
@else
    <div class="alert alert-warning">
        <strong>Datos incompletos detectados:</strong>
        <div class="row mt-2">
            <div class="col-md-6">
                <h6>Alumnos</h6>
                @if($alumnosIncompletos->count() === 0)
                    <p class="text-muted small mb-0">Sin alumnos incompletos.</p>
                @else
                    <ul class="small mb-0">
                        @foreach($alumnosIncompletos as $a)
                            <li>
                                {{ $a->rut_Alumno }}-{{ $a->DV }}
                                @php
                                    $faltan = [];
                                    if(empty($a->nombre_Alumno)) $faltan[] = 'nombre';
                                    if(empty($a->carrera)) $faltan[] = 'carrera';
                                    if(empty($a->correo_Alumno)) $faltan[] = 'correo';
                                @endphp
                                <span class="text-danger">Falta: {{ implode(', ', $faltan) }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="col-md-6">
                <h6>Profesores</h6>
                @if($profesoresIncompletos->count() === 0)
                    <p class="text-muted small mb-0">Sin profesores incompletos.</p>
                @else
                    <ul class="small mb-0">
                        @foreach($profesoresIncompletos as $p)
                            <li>
                                {{ $p->rut_Profesor }}-{{ $p->DV }}
                                @php
                                    $faltan = [];
                                    if(empty($p->nombre_Profesor)) $faltan[] = 'nombre';
                                    if(empty($p->correo_Profesor)) $faltan[] = 'correo';
                                @endphp
                                <span class="text-danger">Falta: {{ implode(', ', $faltan) }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endif
