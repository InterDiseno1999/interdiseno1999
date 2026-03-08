<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Composition;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Dashboard Principal: Administración del Sistema
     * Muestra las métricas globales y los últimos productos cargados.
     */
    public function index()
    {
        // Obtiene los últimos 3 productos para la previsualización del dashboard
        $products = Product::with('compositions')->latest()->take(3)->get();
        
        // Contadores para las tarjetas informativas
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
     * Vista de Edición de Video (Sección Multimedia)
     */
    public function videoEdit()
    {
        // Verifica si el video existe físicamente para informar a la vista
        $videoExists = File::exists(public_path('assets/video/home_background_video.mp4'));
        return view('admin.video.edit', compact('videoExists'));
    }

    /**
     * Procesa la carga y reemplazo del video del Home
     */
    public function videoUpdate(Request $request)
    {
        // Limite de Archivos (500MB)
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
                $fileName = 'home_background_video.mp4';
                
                $path = public_path('assets/video');
                
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }

                if (File::exists($path . '/' . $fileName)) {
                    File::delete($path . '/' . $fileName);
                }

                $file->move($path, $fileName);

                return redirect()->back()->with('success', 'Video actualizado correctamente. Los cambios ya son visibles en el Home.');
            }
        } catch (\Exception $e) {
            Log::error("Error crítico subiendo video: " . $e->getMessage());
            
            return redirect()->back()->withErrors([
                'video_file' => 'Hubo un error al guardar el archivo en el servidor. Revisa los permisos de carpeta.'
            ]);
        }

        return redirect()->back()->withErrors(['video_file' => 'No se pudo procesar el archivo seleccionado.']);
    }
}