@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto px-2 sm:px-4">
    <div class="text-center mb-8 md:mb-12">
        <h1 class="text-2xl md:text-4xl font-bold border-b-2 border-black inline-block pb-2 px-8 md:px-12 uppercase tracking-tighter">
            Editar Variante
        </h1>
    </div>

    <div class="bg-[#C0B7B1]/40 rounded-3xl md:rounded-[2.5rem] p-6 md:p-12 shadow-sm border border-gray-100">
        <form action="{{ route('admin.variants.update', $variant->id) }}" method="POST" class="space-y-8 md:space-y-10">
            @csrf
            @method('PUT')
            
            <!-- Nombre -->
            <div class="space-y-4">
                <label for="name" class="block text-lg md:text-xl font-bold text-gray-800 tracking-tight ml-2">Nombre de la Variante *</label>
                <input type="text" name="name" id="name" required
                    value="{{ old('name', $variant->name) }}"
                    placeholder="Ingresá nombre de la variante" 
                    class="w-full p-4 md:p-5 rounded-2xl border-none focus:ring-2 focus:ring-black shadow-inner outline-none text-base md:text-lg bg-white/80">
                @error('name')
                    <p class="text-red-500 text-[10px] font-black uppercase tracking-widest ml-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Categoría -->
            <div class="space-y-4">
                <label for="category" class="block text-lg md:text-xl font-bold text-gray-800 tracking-tight ml-2">Categoría *</label>
                <div class="relative">
                    <select name="category" id="category" required
                        class="w-full p-4 md:p-5 rounded-2xl border-none focus:ring-2 focus:ring-black shadow-inner outline-none text-base md:text-lg appearance-none bg-white/80">
                        <option value="Base" {{ old('category', $variant->category) == 'Base' ? 'selected' : '' }}>Color Liso (Base)</option>
                        <option value="Estampado" {{ old('category', $variant->category) == 'Estampado' ? 'selected' : '' }}>Diseño (Estampado)</option>
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6">
                <a href="{{ route('admin.variants.index') }}" 
                    class="w-full sm:w-auto text-center px-10 py-4 bg-white border border-gray-200 rounded-2xl font-bold text-sm text-gray-400 hover:text-black transition">
                    Cancelar
                </a>
                <button type="submit" 
                    class="w-full sm:w-auto px-10 py-4 bg-[#333333] text-white rounded-2xl font-bold text-sm uppercase tracking-widest hover:bg-black transition shadow-lg">
                    Actualizar Variante
                </button>
            </div>
        </form>
    </div>
</div>
@endsection