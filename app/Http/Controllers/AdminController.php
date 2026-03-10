<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Composition;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Cambiado de File a Storage
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Definimos el disco de Supabase configurado previamente.
     */
    protected $disk = 'supabase';

    /**
     * Dashboard Principal: Administración del Sistema
     */
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

    /**
     * Lógica de Autenticación para el Portal Secreto
     */
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

    /**
     * Cierre de sesión administrativo
     */
    public function logout()
    {
        session()->forget(['admin_access', 'admin_ip']);
        return redirect()->route('home');
    }

    /**
     * Vista de Edición de Video (SOPORTE SUPABASE)
     */
    public function videoEdit()
    {
        // Verificamos si el video existe en el storage de Supabase
        $videoPath = 'assets/video/home_background_video.mp4';
        $videoExists = Storage::disk($this->disk)->exists($videoPath);
        
        return view('admin.video.edit', compact('videoExists'));
    }

    /**
     * Procesa la carga y reemplazo del video en Supabase
     */
    public function videoUpdate(Request $request)
    {
        // Límite de 500MB
        $request->validate([
            'video_file' => 'required|mimes:mp4,mov,ogg,qt|max:512000', 
        ], [
            'video_file.required' => 'Es necesario seleccionar un archivo de video.',
            'video_file.mimes' => 'El formato debe ser MP4, MOV u OGG.',
            'video_file.max' => 'El archivo no debe superar los 500MB.'
        ]);

        try {
            if ($request->hasFile('video_file')) {
                $file = $request->file('video_file');
                $videoPath = 'assets/video/home_background_video.mp4';
                
                // 1. Subir directamente a Supabase
                // putFileAs maneja el streaming del archivo, ideal para archivos grandes de hasta 500MB
                Storage::disk($this->disk)->putFileAs(
                    'assets/video', 
                    $file, 
                    'home_background_video.mp4',
                    'public'
                );

                return redirect()->back()->with('success', 'Video actualizado correctamente.');
            }
        } catch (\Exception $e) {
            Log::error("Error crítico subiendo video: " . $e->getMessage());
            
            return redirect()->back()->withErrors([
                'video_file' => 'Hubo un error al subir el archivo a la nube. Verifica la conexión con Supabase.'
            ]);
        }

        return redirect()->back()->withErrors(['video_file' => 'No se pudo procesar el archivo seleccionado.']);
    }
}