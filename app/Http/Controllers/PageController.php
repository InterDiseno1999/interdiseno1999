<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Composition;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Muestra la página de inicio con los últimos 3 productos.
     */
    public function home()
    {
        $products = Product::with(['compositions', 'variants'])->latest()->take(3)->get();
        return view('home', compact('products'));
    }

    /**
     * Muestra el catálogo de productos con soporte para filtros, búsqueda y paginación.
     */
    public function products(Request $request)
    {
        $query = Product::with(['compositions', 'variants']);

        // 1. Filtro por búsqueda (Nombre)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Filtrar por composición si el parámetro está presente
        if ($request->filled('composition')) {
            $query->whereHas('compositions', function($q) use ($request) {
                $q->where('compositions.id', $request->composition);
            });
        }

        // 3. Paginación de 18 productos (Novedades primero)
        // Usamos appends para que los filtros persistan al cambiar de página
        $products = $query->latest()->paginate(18)->appends($request->all());

        // Obtenemos todas las composiciones para los botones de filtro
        $compositions = Composition::orderBy('name')->get();

        return view('products', compact('products', 'compositions'));
    }

    /**
     * Muestra el detalle de un producto específico.
     */
    public function show($slug)
    {
        $product = Product::with(['compositions', 'variants'])->where('slug', $slug)->firstOrFail();
        
        $recommended = Product::with(['compositions'])
            ->where('id', '!=', $product->id)
            ->latest()
                ->take(3)
            ->get();

        return view('product-detail', compact('product', 'recommended'));
    }

    /**
     * Muestra la página de contacto.
     */
    public function contact()
    {
        return view('contact');
    }
}