<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PasswordResetLinkController extends Controller
{
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

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        $status = Password::createToken($user);

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $status,
            'created_at' => Carbon::now(),
        ]);

        if ($status) {
            Mail::to($request->email)->send(new ResetPasswordMail($status, $request->email));
        }

        return response()->json(['status' => __('Password reset link sent.')]);
    }
}