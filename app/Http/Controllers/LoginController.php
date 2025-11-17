<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'rut'      => ['required','string','max:12'],
            'password' => ['required','string'],
        ]);

        $rut = $this->normalizeRut($validated['rut']);

        $ok = Auth::attempt([
            'rut'      => $rut,
            'password' => $validated['password'],
        ], $request->boolean('remember'));

        if ($ok) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['rut' => 'Credenciales inválidas'])->onlyInput('rut');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    private function normalizeRut(string $rut): string
    {
        $clean = strtoupper(preg_replace('/[^0-9K]/', '', $rut));
        $numero = substr($clean, 0, -1);
        $dv     = substr($clean, -1);
        return ltrim($numero, '0').'-'.$dv;
    }
}
