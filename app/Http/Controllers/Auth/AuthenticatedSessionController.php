<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            $token = $user->createToken('Cabbie')->plainTextToken;    
    
            return response()->json([
                'userId' => $user->id,
                'token' => $token,
                'role' => $user->role,
            ], 200);
        }
    
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();

            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json(['message' => 'Logged out successfully']);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
    


    public function getFirstLoginStatus(Request $request)
    {
        $user = auth()->user();

        return response()->json([
            'is_first_login' => $user->is_first_login,
        ]);
    }
}