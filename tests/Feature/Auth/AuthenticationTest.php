<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'nullable|boolean', // walidacja dla "remember me"
        ]);

        // Próba logowania
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember'); // Sprawdzamy, czy zaznaczono "remember me"

        if (Auth::attempt($credentials, $remember)) {
            // Logowanie powiodło się
            $request->session()->regenerate();

            return response()->json(['message' => 'Zalogowano pomyślnie!'], 200);
        }

        // Jeśli logowanie się nie powiedzie
        return response()->json(['error' => 'Nieprawidłowe dane logowania'], 401);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Usunięcie tokenów użytkownika
            $user->tokens()->delete();

            // Wylogowanie użytkownika z sesji web
            Auth::guard('web')->logout();

            // Inwalidacja sesji
            $request->session()->invalidate();

            // Regeneracja CSRF tokena
            $request->session()->regenerateToken();

            // Zwrócenie odpowiedzi JSON
            return response()->json(['message' => 'Logged out successfully'], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}