<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $verificationUrl = route(
            'verification.verify',
            ['id' => $this->user->id, 'token' => $this->user->verification_token]
        );
    
        return $this->view('emails.verify-email')
                    ->subject('Zweryfikuj adres e-mail.')
                    ->with([
                        'verificationUrl' => $verificationUrl,
                    ]);
    }
    
}