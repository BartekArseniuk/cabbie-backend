<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminVerificationMail;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                $verificationCode = rand(100000, 999999);

                $request->session()->put('verification_code', $verificationCode);
                $request->session()->put('verification_code_time', Carbon::now());

                Mail::to($user->email)->send(new AdminVerificationMail($verificationCode));

                return response()->json([
                    'message' => 'verification_required'
                ]);
            }

            $token = $user->createToken('Cabbie')->plainTextToken;

            return response()->json([
                'userId' => $user->id,
                'token' => $token,
                'role' => $user->role,
            ], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function verifyCode(Request $request)
    {
        $inputCode = $request->input('code');
        $storedCode = $request->session()->get('verification_code');
        $storedCodeTime = $request->session()->get('verification_code_time');

        if (!$storedCode || !$storedCodeTime) {
            return response()->json(['message' => 'Kod weryfikacyjny nie istnieje'], 400);
        }

        $codeExpirationTime = Carbon::parse($storedCodeTime)->addMinutes(2);

        if (Carbon::now()->greaterThan($codeExpirationTime)) {
            return response()->json(['message' => 'Kod weryfikacyjny wygasł'], 400);
        }

        if ($inputCode == $storedCode) {
            $request->session()->forget('verification_code');
            $request->session()->forget('verification_code_time');

            $user = Auth::user();
            $token = $user->createToken('Cabbie')->plainTextToken;

            return response()->json([
                'message' => 'success',
                'userId' => $user->id,
                'token' => $token,
                'role' => $user->role,
            ], 200);
        }

        return response()->json(['message' => 'Niepoprawny kod'], 400);
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