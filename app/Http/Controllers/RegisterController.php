<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        // ajusta al path real de tu blade (p. ej. 'register' si así se llama)
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => ['required','string','max:80'],
            'rut'                   => ['required','string','max:12', 'regex:/^\d{7,8}-[\dkK]$/'],
            'password'              => ['required','string','min:8','confirmed'],
        ]);

        $rut = $this->normalizeRut($validated['rut']);

        $request->validate([
            'rut' => [Rule::unique(User::class, 'rut')],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'rut'      => $rut,
            'password' => $validated['password'], 
        ]);

        return redirect()->route('login')->with('success', 'Cuenta creada. Ingresa con tus credenciales.');
    }

    private function normalizeRut(string $rut): string
    {
        $clean = strtoupper(preg_replace('/[^0-9K]/', '', $rut));
        $numero = substr($clean, 0, -1);
        $dv     = substr($clean, -1);
        return ltrim($numero, '0').'-'.$dv; // deja formato XXXXXXXX-DV
    }
}
