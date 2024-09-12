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
            'remember' => 'nullable|boolean', 
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return response()->json(['message' => 'Zalogowano pomyślnie!'], 200);
        }

        return response()->json(['error' => 'Nieprawidłowe dane logowania'], 401);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->tokens()->delete();

            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return response()->json(['message' => 'Logged out successfully'], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}