<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function showResetForm($token)
    {
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

        $response = Password::reset($request->only('email', 'password', 'token'), function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('password.reset.success');
        }

        return redirect()->back()->withErrors(['email' => __($response)]);
    }
}
