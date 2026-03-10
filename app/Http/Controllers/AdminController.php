<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Composition;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Disco de Supabase definido en la configuración de archivos.
     */
    protected $disk = 'supabase';

    /**
     * Directorio donde se guardan los videos.
     */
    protected $videoDirectory = 'assets/video';

    /**
     * Nombre base del archivo de video para mantener consistencia.
     */
    protected $videoBaseName = 'home_background_video';

    public function index()
    {
        $products = Product::with('compositions')->latest()->take(3)->get();
        $productsCount = Product::count();
        $compositionsCount = Composition::count();
        $variantsCount = Variant::count();
        
        return view('admin.index', compact(
            'products', 
            'productsCount', 
            'compositionsCount', 
            'variantsCount'
        ));
    }

    public function authenticate(Request $request)
    {
        $password = $request->input('password');
        $masterPassword = env('ADMIN_MASTER_PASSWORD', 'Inter2024');

        if ($password === $masterPassword) {
            session([
                'admin_access' => true, 
                'admin_ip' => $request->ip()
            ]);
            return redirect()->route('admin.index');
        }

        return redirect()->back()->with('error', 'Credenciales no válidas.');
    }

    public function logout()
    {
        session()->forget(['admin_access', 'admin_ip']);
        return redirect()->route('home');
    }

    /**
     * Vista de Edición: Busca cualquier video (mp4 o mov) en la carpeta de la nube.
     */
    public function videoEdit()
    {
        // Escaneamos el directorio para verificar existencia real
        $files = Storage::disk($this->disk)->files($this->videoDirectory);
        
        $videoExists = false;
        foreach ($files as $file) {
            if (str_contains($file, $this->videoBaseName)) {
                $videoExists = true;
                break;
            }
        }
        
        return view('admin.video.edit', compact('videoExists'));
    }

    /**
     * Procesa la carga aceptando MP4 y MOV con configuración técnica para Supabase.
     */
    public function videoUpdate(Request $request)
    {
        // Validaciones robustas incluyendo mimetypes de Apple
        $request->validate([
            'video_file' => [
                'required',
                'file',
                'mimes:mp4,mov,qt', 
                'mimetypes:video/mp4,video/quicktime',
                'max:512000' // 500MB
            ],
        ], [
            'video_file.required' => 'Es necesario seleccionar un archivo.',
            'video_file.mimes' => 'Formato no soportado (usa MP4 o MOV).',
            'video_file.max' => 'El video es demasiado pesado (máx 500MB).'
        ]);

        try {
            if ($request->hasFile('video_file')) {
                $file = $request->file('video_file');
                $extension = strtolower($file->getClientOriginalExtension());
                $fileName = $this->videoBaseName . '.' . $extension;
                $mimeType = $file->getMimeType();
                
                // 1. LIMPIEZA: Borramos cualquier video previo para no duplicar espacio (mp4 y mov)
                $existingFiles = Storage::disk($this->disk)->files($this->videoDirectory);
                foreach ($existingFiles as $existing) {
                    if (str_contains($existing, $this->videoBaseName)) {
                        Storage::disk($this->disk)->delete($existing);
                    }
                }

                // 2. SUBIDA: Usamos opciones avanzadas para asegurar que Supabase entienda el archivo
                // Especificar 'ContentType' es CLAVE para que los .mov funcionen en navegadores
                Storage::disk($this->disk)->putFileAs(
                    $this->videoDirectory, 
                    $file, 
                    $fileName,
                    [
                        'visibility'  => 'public',
                        'ContentType' => $mimeType, 
                    ]
                );

                return redirect()->back()->with('success', 'Video (' . strtoupper($extension) . ') actualizado y optimizado en la nube.');
            }
        } catch (\Exception $e) {
            Log::error("Error crítico subiendo video: " . $e->getMessage());
            return redirect()->back()->withErrors([
                'video_file' => 'Hubo un problema de conexión con el almacenamiento. Intenta de nuevo.'
            ]);
        }

        return redirect()->back()->withErrors(['video_file' => 'No se pudo procesar el archivo.']);
    }
}