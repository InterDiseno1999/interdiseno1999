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
        $files = Storage::disk($this->disk)->files($this->videoDirectory);
        
        $currentVideo = collect($files)->first(function($file) {
            return str_contains($file, $this->videoBaseName);
        });

        $videoExists = !is_null($currentVideo);
        
        return view('admin.video.edit', compact('videoExists'));
    }

    /**
     * Procesa la carga aceptando MP4 y MOV con configuración técnica para Supabase.
     */
    public function videoUpdate(Request $request)
    {
        // Validaciones robustas incluyendo mimetypes de Apple y contenedores MP4
        $request->validate([
            'video_file' => [
                'required',
                'file',
                'mimes:mp4,mov,qt', 
                'mimetypes:video/mp4,video/quicktime,video/x-m4v',
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
                $finalExtension = ($extension === 'qt') ? 'mov' : $extension;
                $fileName = $this->videoBaseName . '.' . $finalExtension;
                
                $mimeType = $file->getMimeType();

                $existingFiles = Storage::disk($this->disk)->files($this->videoDirectory);
                foreach ($existingFiles as $existing) {
                    if (str_contains($existing, $this->videoBaseName)) {
                        Storage::disk($this->disk)->delete($existing);
                    }
                }

                Storage::disk($this->disk)->putFileAs(
                    $this->videoDirectory, 
                    $file, 
                    $fileName,
                    [
                        'visibility'   => 'public',
                        'ContentType'  => $mimeType,
                        'CacheControl' => 'max-age=31536000',
                    ]
                );

                return redirect()->back()->with('success', 'Video (' . strtoupper($finalExtension) . ') actualizado y vinculado correctamente.');
            }
        } catch (\Exception $e) {
            Log::error("Error crítico subiendo video: " . $e->getMessage());
            return redirect()->back()->withErrors([
                'video_file' => 'Hubo un problema al guardar en la nube: ' . $e->getMessage()
            ]);
        }

        return redirect()->back()->withErrors(['video_file' => 'No se pudo procesar el archivo seleccionado.']);
    }
}