<?php

namespace App\Http\Controllers;

use App\Models\Composition;
use Illuminate\Http\Request;

class CompositionController extends Controller
{
    /**
     * Listado de composiciones ordenadas por ID (Novedades primero)
     */
    public function index()
    {
        $compositions = Composition::orderBy('id', 'asc')->get();
        return view('admin.compositions.index', compact('compositions'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('admin.compositions.create');
    }

    /**
     * Guardar nueva composición
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:compositions,name|max:255'
        ], [
            'name.unique' => 'Esta composición ya existe en el sistema.'
        ]);

        Composition::create($request->only('name'));

        return redirect()->route('admin.compositions.index')
                         ->with('success', 'La composición se ha creado con éxito.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $composition = Composition::findOrFail($id);
        return view('admin.compositions.edit', compact('composition'));
    }

    /**
     * Actualizar composición existente
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|unique:compositions,name,' . $id
        ]);

        $composition = Composition::findOrFail($id);
        $composition->update($request->only('name'));

        return redirect()->route('admin.compositions.index')
                         ->with('success', 'Composición actualizada correctamente.');
    }

    /**
     * Eliminar composición
     */
    public function destroy($id)
    {
        $composition = Composition::findOrFail($id);
        $composition->delete();

        return redirect()->route('admin.compositions.index')
                         ->with('success', 'Composición eliminada del sistema.');
    }
}