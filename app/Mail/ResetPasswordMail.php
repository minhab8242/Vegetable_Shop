<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;


    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Đặt lại mật khẩu - Vegetable Store',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.reset-password',
            with: [
                'resetUrl' => route('password.reset', ['token' => $this->token, 'email' => $this->email]),
                'email' => $this->email,
            ]
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
