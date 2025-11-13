<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    private function normalizeRut(string $rut): string {
        return strtoupper(preg_replace('/[^0-9K]/', '', $rut));
    }

    public function show() {
        return view('auth.register');
    }

    public function register(Request $r) {
        $rutNorm = $this->normalizeRut((string)$r->input('rut'));

        // Validación mínima y directa
        $r->validate([
            'name'                  => ['required','string','max:100'],
            'rut'                   => ['required','string','max:12','unique:users,rut'],
            'password'              => ['required','string','min:8','confirmed'],
        ]);

        $user = User::create([
            'name'     => $r->input('name'),
            'email'    => $r->input('email'), // opcional; puedes omitirlo en la vista
            'rut'      => $rutNorm,
            'password' => Hash::make($r->input('password')),
        ]);

        Auth::login($user);
        $r->session()->regenerate();

        return redirect()->route('home');
    }
}