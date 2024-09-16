<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    protected function isTokenValid($token)
    {
        $resetEntry = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$resetEntry) {
            return false;
        }

        $tokenExpirationTime = 60;
        $tokenCreatedAt = Carbon::parse($resetEntry->created_at);

        if ($tokenCreatedAt->addMinutes($tokenExpirationTime)->isPast()) {
            DB::table('password_reset_tokens')->where('token', $token)->delete();
            return false;
        }

        return true;
    }

    public function showResetForm($token)
    {
        if (!$this->isTokenValid($token)) {
            return redirect()->route('password.reset.expired');
        }

        return view('auth.reset-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!$this->isTokenValid($request->token)) {
            return redirect()->route('password.reset.expired');
        }

        $response = Password::reset($request->only('email', 'password', 'token'), function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        if ($response == Password::PASSWORD_RESET) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return redirect()->route('password.reset.success');
        }

        return redirect()->back()->withErrors(['email' => __($response)]);
    }
}