<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Procesa el envío del formulario de contacto.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|min:5',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.email'   => 'El formato de correo no es válido.',
            'message.min'   => 'El mensaje es demasiado corto.'
        ]);

        try {
            Mail::to('tomas.espiro@davinci.edu.ar')->send(new ContactMail($validated));

            return back()->with('success', '¡Gracias! Tu consulta ha sido enviada correctamente.');

        } catch (\Exception $e) {
            Log::error("Error crítico enviando correo: " . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['mail_error' => 'No pudimos enviar el correo en este momento. Por favor, intenta más tarde.']);
        }
    }
}