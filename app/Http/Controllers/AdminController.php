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
     * Vista de Edición: Busca cualquier video (mp4 o mov) en la carpeta.
     */
    public function videoEdit()
    {
        // Buscamos cualquier archivo que empiece con nuestro nombre base en Supabase
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
     * Procesa la carga aceptando MP4 y MOV para compatibilidad con Mac.
     */
    public function videoUpdate(Request $request)
    {
        // Añadimos mimetypes para mayor seguridad con archivos Apple (QuickTime)
        $request->validate([
            'video_file' => [
                'required',
                'file',
                'mimes:mp4,mov,qt', // qt = QuickTime
                'mimetypes:video/mp4,video/quicktime',
                'max:512000' // 500MB
            ],
        ], [
            'video_file.required' => 'Debes seleccionar un archivo.',
            'video_file.mimes' => 'El formato debe ser MP4 o MOV (Mac).',
            'video_file.mimetypes' => 'El tipo de video no es compatible.',
            'video_file.max' => 'El archivo supera el límite de 500MB.'
        ]);

        try {
            if ($request->hasFile('video_file')) {
                $file = $request->file('video_file');
                $extension = $file->getClientOriginalExtension();
                $fileName = $this->videoBaseName . '.' . $extension;
                
                // 1. Limpieza: Borramos archivos de video viejos (sean mp4 o mov)
                $existingFiles = Storage::disk($this->disk)->files($this->videoDirectory);
                foreach ($existingFiles as $existing) {
                    if (str_contains($existing, $this->videoBaseName)) {
                        Storage::disk($this->disk)->delete($existing);
                    }
                }

                // 2. Subida del nuevo archivo a Supabase
                Storage::disk($this->disk)->putFileAs(
                    $this->videoDirectory, 
                    $file, 
                    $fileName,
                    'public'
                );

                return redirect()->back()->with('success', 'Video (' . strtoupper($extension) . ') actualizado correctamente.');
            }
        } catch (\Exception $e) {
            Log::error("Error subiendo video a Supabase: " . $e->getMessage());
            return redirect()->back()->withErrors([
                'video_file' => 'Error de conexión con la nube. Intenta de nuevo.'
            ]);
        }

        return redirect()->back()->withErrors(['video_file' => 'No se pudo procesar el archivo.']);
    }
}