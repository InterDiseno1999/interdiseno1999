<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    /**
     * Listado de variantes con filtros, paginación y orden por ID.
     */
    public function index(Request $request)
    {
        $query = Variant::withCount('products');

        // Filtro por Categoría
        if ($request->filled('category') && $request->category !== 'Todos') {
            $query->where('category', $request->category);
        }

        // Filtro por Búsqueda
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // CAMBIO: Ahora se ordena por ID descendente para ver lo más nuevo primero
        $variants = $query->orderBy('id', 'asc')->paginate(15)->appends($request->all());

        return view('admin.variants.index', compact('variants'));
    }

    public function create()
    {
        return view('admin.variants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:variants,name|max:255',
            'category' => 'required|in:Base,Estampado'
        ]);

        Variant::create($request->all());

        return redirect()->route('admin.variants.index')->with('success', 'Variante creada con éxito.');
    }

    public function edit($id)
    {
        $variant = Variant::findOrFail($id);
        return view('admin.variants.edit', compact('variant'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|unique:variants,name,' . $id,
            'category' => 'required|in:Base,Estampado'
        ]);

        $variant = Variant::findOrFail($id);
        $variant->update($request->all());

        return redirect()->route('admin.variants.index')->with('success', 'Variante actualizada.');
    }

    public function destroy($id)
    {
        $variant = Variant::findOrFail($id);
        $variant->delete();

        return redirect()->route('admin.variants.index')->with('success', 'Variante eliminada.');
    }
}