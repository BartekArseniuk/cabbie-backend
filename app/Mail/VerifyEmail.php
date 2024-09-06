<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $verificationUrl = route(
            'verification.verify',
            ['id' => $this->user->id, 'token' => $this->user->verification_token]
        );
    
        return $this->view('emails.verify-email')
                    ->subject('Verify Your Email Address')
                    ->with([
                        'verificationUrl' => $verificationUrl,
                    ]);
    }
    
}
