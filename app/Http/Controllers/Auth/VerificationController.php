<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    public function verify(Request $request, $id, $token)
    {
        $user = User::findOrFail($id);

        if ($user->verification_token !== $token) {
            return redirect()->route('verify-expired');
        }

        $tokenExpirationTime = 60;
        $tokenGeneratedAt = \Carbon\Carbon::parse($user->verification_token_created_at);
        if ($tokenGeneratedAt->addMinutes($tokenExpirationTime)->isPast()) {
            return redirect()->route('verify-expired');
        }

        $user->markEmailAsVerified();
        $user->verification_token = null;
        $user->verification_token_created_at = null;
        $user->save();

        return redirect()->route('verify-thankyou');
    }

    public function resendVerificationEmail($id)
    {
        $user = User::findOrFail($id);

        if ($user->email_verified_at) {
            return response()->json(['message' => 'E-mail został już zweryfikowany.'], 400);
        }

        $user->verification_token = Str::random(40);
        $user->verification_token_created_at = now();
        $user->save();

        Mail::to($user->email)->send(new VerifyEmail($user));

        return response()->json(['message' => 'E-mail weryfikacyjny został wysłany ponownie.']);
    }
}