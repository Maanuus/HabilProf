<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $rutNormalizado = $this->normalizeRut($request->input('rut', ''));
        $request->merge(['rut' => $rutNormalizado]);

        $validated = $request->validate([
            'name'                  => ['required','string','max:80'],
            'rut'                   => ['required','string','max:12','regex:/^\d{7,8}-[\dkK]$/', Rule::unique('users','rut')],
            'password'              => ['required','string','min:8','confirmed'],
        ], [
            'rut.unique'            => 'Este RUT ya tiene una cuenta registrada.',
            'rut.regex'             => 'Formato de RUT inválido. Use 12345678-9 o 12345678-K.',
            'password.confirmed'    => 'Las contraseñas no coinciden.',
            'password.min'          => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        [$rutNum, $dv] = $this->splitRut($rutNormalizado);

        $existeProfesor = DB::connection('pgsql2')
            ->table('Profesor')
            ->where('rut_Profesor', $rutNum)
            ->where('DV', $dv)
            ->exists();

        if (!$existeProfesor) {
            return back()
                ->withErrors(['rut' => 'El RUT ingresado no corresponde a un profesor registrado en los sistemas de la UCSC.'])
                ->withInput();
        }

        // Crea el usuario en 'users' (encripta la contraseña)
        User::create([
            'name'     => $validated['name'],
            'rut'      => $rutNormalizado,
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Cuenta creada. Ingresa con tus credenciales.');
    }

    private function normalizeRut(string $rut): string
    {
        $clean  = strtoupper(preg_replace('/[^0-9K]/', '', $rut));
        $numero = substr($clean, 0, -1);
        $dv     = substr($clean, -1);
        return ltrim($numero, '0') . '-' . $dv;
    }

    private function splitRut(string $rut): array
    {
        [$numero, $dv] = explode('-', strtoupper($rut));
        return [(int) $numero, $dv];
    }
}