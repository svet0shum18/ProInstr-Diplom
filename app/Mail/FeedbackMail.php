<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS')) // Ваш email
               ->to(env('ADMIN_EMAIL'))
               ->replyTo($this->data['email'])   // Ответ - клиенту
               ->subject('Новое сообщение от ' . $this->data['email'])
               ->view('emails.feedback', ['data' => $this->data]);
    }
}
