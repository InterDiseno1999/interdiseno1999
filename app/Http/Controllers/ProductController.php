<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Composition;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Muestra el listado de productos con filtros funcionales.
     */
    public function index(Request $request)
    {
        $query = Product::with(['compositions', 'variants']);

        // 1. Filtro por Stock (1 = Disponible, 0 = Sin Stock)
        if ($request->filled('stock')) {
            $query->where('stock', $request->stock);
        }

        // 2. Filtro por Composición (Relación Muchos a Muchos)
        if ($request->filled('composition')) {
            $query->whereHas('compositions', function($q) use ($request) {
                $q->where('compositions.id', $request->composition);
            });
        }

        // 3. Orden por Fecha (Por defecto: más nuevos primero)
        $sort = $request->get('sort', 'desc');
        $query->orderBy('created_at', $sort);

        // Obtenemos los productos paginados manteniendo los filtros en los enlaces
        $products = $query->paginate(15)->appends($request->all());

        // Cargamos todas las composiciones para el selector de filtros
        $compositions = Composition::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'compositions'));
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        $compositions = Composition::orderBy('name')->get();
        $baseVariants = Variant::where('category', 'Base')->orderBy('name')->get();
        $designVariants = Variant::where('category', 'Estampado')->orderBy('name')->get();
        
        return view('admin.products.create', compact('compositions', 'baseVariants', 'designVariants'));
    }

    /**
     * Procesa y guarda el producto con soporte para imágenes recortadas (Cropper.js).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'width' => 'required|string|max:50',
            'compositions' => 'required|array|min:1',
            'compositions.*' => 'exists:compositions,id',
            // La imagen principal es obligatoria, ya sea como archivo o como recorte Base64
            'main_image' => 'required_without:main_image_cropped|nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'main_image_cropped' => 'required_without:main_image|nullable|string',
        ], [
            'compositions.required' => 'Debes seleccionar al menos una composición.',
            'main_image.required_without' => 'La imagen principal es obligatoria (debes seleccionarla y recortarla).'
        ]);

        $mainPath = null;

        try {
            return DB::transaction(function () use ($request, &$mainPath) {
                
                // 1. Procesar Imagen Principal (Prioridad al recorte Base64)
                if ($request->filled('main_image_cropped')) {
                    $mainPath = $this->saveBase64Image($request->main_image_cropped, 'products/main');
                } else {
                    $mainPath = $request->file('main_image')->store('products/main', 'public');
                }

                // 2. Crear registro del Producto
                $product = Product::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'description' => $request->description,
                    'width' => $request->width,
                    'stock' => $request->stock == '1',
                    'has_design' => $request->has_design === 'si',
                    'image' => $mainPath,
                ]);

                // 3. Vincular Multi-Composiciones
                $product->compositions()->attach($request->compositions);

                // 4. Procesar Variantes (Base y Diseño)
                $this->processVariants($request, $product);

                return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente.');
            });

        } catch (\Exception $e) {
            if ($mainPath) Storage::disk('public')->delete($mainPath);
            Log::error("Error en ProductController@store: " . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error al guardar el producto: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $product = Product::with(['compositions', 'variants'])->findOrFail($id);
        $compositions = Composition::orderBy('name')->get();
        $baseVariants = Variant::where('category', 'Base')->orderBy('name')->get();
        $designVariants = Variant::where('category', 'Estampado')->orderBy('name')->get();
        
        return view('admin.products.edit', compact('product', 'compositions', 'baseVariants', 'designVariants'));
    }

    /**
     * Actualiza el producto sincronizando composiciones y variantes con soporte Cropper.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'width' => 'required|string',
            'compositions' => 'required|array|min:1',
        ]);

        $product = Product::findOrFail($id);

        try {
            return DB::transaction(function () use ($request, $product) {
                // 1. Actualizar Imagen Principal (Si se envió una nueva recortada o archivo)
                if ($request->filled('main_image_cropped')) {
                    if ($product->image) Storage::disk('public')->delete($product->image);
                    $product->image = $this->saveBase64Image($request->main_image_cropped, 'products/main');
                } elseif ($request->hasFile('main_image')) {
                    if ($product->image) Storage::disk('public')->delete($product->image);
                    $product->image = $request->file('main_image')->store('products/main', 'public');
                }

                // 2. Actualizar datos básicos
                $product->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'description' => $request->description,
                    'width' => $request->width,
                    'stock' => $request->stock == '1',
                    'has_design' => $request->has_design === 'si',
                ]);

                // 3. Sincronizar Composiciones
                $product->compositions()->sync($request->compositions);

                // 4. Sincronizar Variantes (Manual para manejar recortes)
                $this->syncVariants($request, $product);

                return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
            });
        } catch (\Exception $e) {
            Log::error("Error en ProductController@update: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Elimina el producto y limpia los archivos del storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        foreach ($product->variants as $variant) {
            if ($variant->pivot->variant_image) {
                Storage::disk('public')->delete($variant->pivot->variant_image);
            }
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado por completo.');
    }

    // --- MÉTODOS PRIVADOS DE APOYO ---

    /**
     * Decodifica una cadena Base64 y la guarda como archivo físico.
     */
    private function saveBase64Image($base64Data, $folder)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $type)) {
            $data = substr($base64Data, strpos($base64Data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, webp, etc.
            $data = base64_decode($data);
            
            $fileName = Str::random(40) . '.' . $type;
            $path = $folder . '/' . $fileName;
            
            Storage::disk('public')->put($path, $data);
            return $path;
        }
        throw new \Exception("El formato de la imagen recortada no es válido.");
    }

    /**
     * Procesa la inserción inicial de variantes (Base64 o File).
     */
    private function processVariants($request, $product)
    {
        // Colores Base
        if ($request->has('base_variants')) {
            foreach ($request->base_variants as $vId) {
                $path = null;
                if ($request->filled("variant_images_cropped.$vId")) {
                    $path = $this->saveBase64Image($request->variant_images_cropped[$vId], 'products/variants');
                } elseif ($request->hasFile("variant_images.$vId")) {
                    $path = $request->file("variant_images.$vId")->store('products/variants', 'public');
                }
                $product->variants()->attach($vId, ['variant_image' => $path]);
            }
        }

        // Estampados
        if ($request->has_design === 'si' && $request->has('design_variants')) {
            foreach ($request->design_variants as $dvId) {
                $path = null;
                if ($request->filled("design_variant_images_cropped.$dvId")) {
                    $path = $this->saveBase64Image($request->design_variant_images_cropped[$dvId], 'products/variants');
                } elseif ($request->hasFile("design_variant_images.$dvId")) {
                    $path = $request->file("design_variant_images.$dvId")->store('products/variants', 'public');
                }
                $product->variants()->attach($dvId, ['variant_image' => $path]);
            }
        }
    }

    /**
     * Sincroniza variantes en la actualización, permitiendo recortes nuevos.
     */
    private function syncVariants($request, $product)
    {
        $variantSyncData = [];

        // Lógica para variantes base
        if ($request->has('base_variants')) {
            foreach ($request->base_variants as $vId) {
                $existing = $product->variants()->where('variant_id', $vId)->first();
                $path = $existing ? $existing->pivot->variant_image : null;

                if ($request->filled("variant_images_cropped.$vId")) {
                    if ($path) Storage::disk('public')->delete($path);
                    $path = $this->saveBase64Image($request->variant_images_cropped[$vId], 'products/variants');
                }
                $variantSyncData[$vId] = ['variant_image' => $path];
            }
        }

        // Lógica para variantes de diseño
        if ($request->has_design === 'si' && $request->has('design_variants')) {
            foreach ($request->design_variants as $dvId) {
                $existing = $product->variants()->where('variant_id', $dvId)->first();
                $path = $existing ? $existing->pivot->variant_image : null;

                if ($request->filled("design_variant_images_cropped.$dvId")) {
                    if ($path) Storage::disk('public')->delete($path);
                    $path = $this->saveBase64Image($request->design_variant_images_cropped[$dvId], 'products/variants');
                }
                $variantSyncData[$dvId] = ['variant_image' => $path];
            }
        }

        $product->variants()->sync($variantSyncData);
    }
}