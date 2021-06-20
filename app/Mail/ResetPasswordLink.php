<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordLink extends Mailable
{
    use Queueable, SerializesModels;

    private $email, $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->subject('Réinitialisation de mot de passe')
        ->view('emails.reset-password')
        ->with(['token' => $this->token, 'email' => $this->email]);
    }
}
