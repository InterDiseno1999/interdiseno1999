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
        // 1. Validamos estrictamente los datos
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
            // 2. Enviamos el mail pasando el arreglo $validated (que nunca será null si pasó la validación)
            // IMPORTANTE: Cambia 'tu-email@ejemplo.com' por tu dirección real de recepción.
            Mail::to('tomas.espiro@davinci.edu.ar')->send(new ContactMail($validated));

            return back()->with('success', '¡Gracias! Tu consulta ha sido enviada correctamente.');

        } catch (\Exception $e) {
            // Registramos el error exacto en storage/logs/laravel.log para debug
            Log::error("Error crítico enviando correo: " . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['mail_error' => 'No pudimos enviar el correo en este momento. Por favor, intenta más tarde.']);
        }
    }
}