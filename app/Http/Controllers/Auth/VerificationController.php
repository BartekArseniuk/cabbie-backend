<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    public function verify(Request $request, $id, $token)
    {
        $user = User::findOrFail($id);
    
        if ($user->verification_token !== $token) {
            abort(403, 'Nieprawidłowy link weryfikacyjny.');
        }
    
        $user->markEmailAsVerified();
        $user->verification_token = null;
        $user->save();
    
        return redirect()->route('verify-thankyou');
    }    
}
