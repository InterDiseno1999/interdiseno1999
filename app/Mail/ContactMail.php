<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data)
    {
        //
    }

    /**
     * Define el sobre del mensaje.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva consulta desde la Web - InterDiseño',
            replyTo: [
                new Address(
                    $this->data['email'] ?? config('mail.from.address'), 
                    $this->data['name'] ?? 'Cliente Web'
                ),
            ],
        );
    }

    /**
     * Define el contenido del mensaje.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact', 
        );
    }

    /**
     * Define los archivos adjuntos.
     */
    public function attachments(): array
    {
        return [];
    }
}