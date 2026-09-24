@if($alumnosIncompletos->count() === 0 && $profesoresIncompletos->count() === 0)
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm flex items-center shadow-xs">
        <svg class="w-5 h-5 mr-2 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        <span>Todos los registros de alumnos y profesores se encuentran completos y al día.</span>
    </div>
@else
    <div class="bg-white rounded-xl shadow-md border border-amber-200 overflow-hidden">
        <div class="bg-amber-50 border-b border-amber-200 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-amber-600 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <h2 class="text-sm font-bold text-amber-900 uppercase tracking-wider">Registros Incompletos Detectados</h2>
            </div>
            <span class="text-xs bg-amber-200 text-amber-900 font-semibold px-2.5 py-0.5 rounded-full">
                {{ $alumnosIncompletos->count() + $profesoresIncompletos->count() }} por sincronizar
            </span>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Bloque Alumnos -->
            <div>
                <h3 class="text-sm font-semibold text-gray-800 mb-3 flex items-center">
                    <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                    Alumnos con datos faltantes ({{ $alumnosIncompletos->count() }})
                </h3>
                @if($alumnosIncompletos->count() === 0)
                    <p class="text-xs text-gray-400 italic">Sin alumnos incompletos.</p>
                @else
                    <ul class="divide-y divide-gray-100 max-h-60 overflow-y-auto pr-2 text-xs">
                        @foreach($alumnosIncompletos as $a)
                            <li class="py-2 flex items-center justify-between">
                                <span class="font-mono font-medium text-gray-800">{{ $a->rut_Alumno }}-{{ $a->DV }}</span>
                                @php
                                    $faltan = [];
                                    if(empty($a->nombre_Alumno)) $faltan[] = 'nombre';
                                    if(empty($a->carrera)) $faltan[] = 'carrera';
                                    if(empty($a->correo_Alumno)) $faltan[] = 'correo';
                                @endphp
                                <span class="px-2 py-0.5 bg-red-50 text-red-700 border border-red-200 rounded text-[11px] font-medium">
                                    Falta: {{ implode(', ', $faltan) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Bloque Profesores -->
            <div>
                <h3 class="text-sm font-semibold text-gray-800 mb-3 flex items-center">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                    Profesores con datos faltantes ({{ $profesoresIncompletos->count() }})
                </h3>
                @if($profesoresIncompletos->count() === 0)
                    <p class="text-xs text-gray-400 italic">Sin profesores incompletos.</p>
                @else
                    <ul class="divide-y divide-gray-100 max-h-60 overflow-y-auto pr-2 text-xs">
                        @foreach($profesoresIncompletos as $p)
                            <li class="py-2 flex items-center justify-between">
                                <span class="font-mono font-medium text-gray-800">{{ $p->rut_Profesor }}-{{ $p->DV }}</span>
                                @php
                                    $faltan = [];
                                    if(empty($p->nombre_Profesor)) $faltan[] = 'nombre';
                                    if(empty($p->correo_Profesor)) $faltan[] = 'correo';
                                @endphp
                                <span class="px-2 py-0.5 bg-red-50 text-red-700 border border-red-200 rounded text-[11px] font-medium">
                                    Falta: {{ implode(', ', $faltan) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endif
