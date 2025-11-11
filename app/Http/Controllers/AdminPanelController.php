<?php

namespace App\Http\Controllers;

use App\Services\ModulosSyncService;

class AdminPanelController extends Controller
{
    public function panel(ModulosSyncService $sync)
    {
        $result = $sync->obtenerIncompletos();
        return view('admin.panel', [
            'alumnosIncompletos' => $result['alumnos'],
            'profesoresIncompletos' => $result['profesores'],
        ]);
    }

    public function ejecutarSync(ModulosSyncService $sync)
    {
        $incompletos = $sync->completarIncompletos();
        $notas = $sync->sincronizarNotas();

        return redirect()->route('admin.panel')
            ->with('sync_result', [
                'incompletos' => $incompletos,
                'notas' => $notas,
            ]);
    }
}
