<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SyncHistoryController extends Controller
{
    /**
     * Muestra el historial de cambios de sincronización
     */
    public function index(Request $request)
    {
        $archivo = storage_path('logs/sync_changes.json');
        $cambios = [];

        if (file_exists($archivo)) {
            $contenido = file_get_contents($archivo);
            $cambios = json_decode($contenido, true) ?? [];
        }

        // Invertir array para mostrar los más recientes primero
        $cambios = array_reverse($cambios);

        // Filtrado opcional por tipo
        if ($request->has('tipo') && !empty($request->tipo)) {
            $cambios = array_filter($cambios, function($c) use ($request) {
                return $c['tipo'] === $request->tipo;
            });
        }

        // Filtrado opcional por RUT
        if ($request->has('rut') && !empty($request->rut)) {
            $cambios = array_filter($cambios, function($c) use ($request) {
                return stripos($c['rut'], $request->rut) !== false;
            });
        }

        // Paginación manual simple (opcional)
        $perPage = 50;
        $page = $request->get('page', 1);
        $total = count($cambios);
        $cambios = array_slice($cambios, ($page - 1) * $perPage, $perPage);

        return view('admin.sync-history', [
            'cambios' => $cambios,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
        ]);
    }

    /**
     * Limpia el historial de cambios
     */
    public function clear()
    {
        $archivo = storage_path('logs/sync_changes.json');
        
        if (file_exists($archivo)) {
            unlink($archivo);
        }

        return redirect()->route('admin.sync-history')->with('success', 'Historial limpiado correctamente');
    }
}
