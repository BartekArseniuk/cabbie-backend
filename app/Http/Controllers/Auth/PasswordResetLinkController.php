<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
    
        $user = \App\Models\User::where('email', $request->email)->first();
    
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => [__('We couldn\'t find a user with that email address.')],
            ]);
        }
    
        $status = Password::createToken($user);
    
        if ($status) {
            Mail::to($request->email)->send(new ResetPasswordMail($status, $request->email));
        }
    
        return response()->json(['status' => __('Password reset link sent.')]);
    }
    
}
