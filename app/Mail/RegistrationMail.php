<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $content;
    public string $verificationLink;

    /**
     * @param string $content list content
     * @param string $verificationLink verification link to confirm registration
     */
    public function __construct($content, $verificationLink)
    {
        $this->content = $content;
        $this->verificationLink = $verificationLink;
    }

    /**
     * mail build
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to Beat Believers!')
            ->view('emails.registration');
    }
}

