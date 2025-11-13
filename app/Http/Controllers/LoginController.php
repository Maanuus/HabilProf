<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private function normalizeRut(string $rut): string {
        return strtoupper(preg_replace('/[^0-9K]/', '', $rut));
    }

    public function show() {
        return view('auth.login');
    }

    public function login(Request $r) {
        $cred = [
            'rut'      => $this->normalizeRut((string)$r->input('rut')),
            'password' => (string)$r->input('password'),
        ];

        if (Auth::attempt($cred, $r->boolean('remember'))) {
            $r->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['rut' => 'Credenciales inválidas'])->onlyInput('rut');
    }

    public function logout(Request $r) {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login');
    }
}