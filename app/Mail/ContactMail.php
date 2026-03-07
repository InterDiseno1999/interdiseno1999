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

    /**
     * Usamos "public array $data" directamente en el constructor (Property Promotion).
     * Esto asegura que la propiedad sea accesible tanto en envelope() como en la vista.
     */
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
            // Usamos ?? para dar un valor por defecto si las llaves no existen por algún motivo
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
            view: 'emails.contact', // Asegúrate de que este archivo exista en resources/views/emails/contact.blade.php
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