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
        try {
            $incompletos = $sync->completarIncompletos();
            $notas = $sync->sincronizarNotas();

            return redirect()->route('admin.panel')
                ->with('sync_result', [
                    'incompletos' => $incompletos,
                    'notas' => $notas,
                ]);
        } catch (\Throwable $e) {
            $msg = mb_convert_encoding($e->getMessage(), 'UTF-8', 'auto');
            return redirect()->route('admin.panel')
                ->with('sync_error', 'No fue posible sincronizar con el sistema externo: ' . $msg);
        }
    }
}
