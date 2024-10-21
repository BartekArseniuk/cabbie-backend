<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class EmailController extends Controller
{
    public function send(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Mail::to('biuro@cabbie.pl')->send(new ContactMail($validatedData));

        return response()->json(['message' => 'Wiadomość została wysłana pomyślnie.']);
    }
}
