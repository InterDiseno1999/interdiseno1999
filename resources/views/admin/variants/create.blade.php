@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-2 sm:px-4">
    <!-- Título de la Sección -->
    <div class="text-center mb-8 md:mb-12">
        <h1 class="text-2xl md:text-4xl font-bold border-b-2 border-black inline-block pb-2 px-8 md:px-16 uppercase tracking-tighter text-gray-800">
            Crear Nueva Variante
        </h1>
    </div>

    <!-- Card del Formulario -->
    <div class="bg-[#C0B7B1]/40 rounded-3xl md:rounded-[2.5rem] p-6 md:p-12 shadow-sm border border-gray-100">
        <form action="{{ route('admin.variants.store') }}" method="POST" class="space-y-10 md:space-y-12">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                <!-- Campo: Nombre -->
                <div class="space-y-4">
                    <label for="name" class="block text-lg md:text-xl font-bold text-gray-800 tracking-tight ml-2">Nombre de Color/Diseño *</label>
                    <input type="text" name="name" id="name" required autofocus
                        value="{{ old('name') }}"
                        placeholder="Ingresá nombre de la variante" 
                        class="w-full p-4 md:p-5 rounded-2xl border-none focus:ring-2 focus:ring-black shadow-inner outline-none text-base md:text-lg bg-white/80">
                    
                    @error('name')
                        <p class="text-red-600 text-[10px] font-black uppercase tracking-widest ml-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: Categoría -->
                <div class="space-y-4">
                    <label for="category" class="block text-lg md:text-xl font-bold text-gray-800 tracking-tight ml-2">Categoría *</label>
                    <div class="relative">
                        <select name="category" id="category" required
                            class="w-full p-4 md:p-5 rounded-2xl border-none focus:ring-2 focus:ring-black shadow-inner outline-none text-base md:text-lg appearance-none bg-white/80">
                            <option value="" disabled selected>Asignar Categoría</option>
                            <option value="Base" {{ old('category') == 'Base' ? 'selected' : '' }}>Color Liso (Base)</option>
                            <option value="Estampado" {{ old('category') == 'Estampado' ? 'selected' : '' }}>Diseño (Estampado)</option>
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    @error('category')
                        <p class="text-red-600 text-[10px] font-black uppercase tracking-widest ml-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6">
                <a href="{{ route('admin.variants.index') }}" 
                    class="w-full sm:w-auto text-center px-12 py-4 bg-white border border-gray-200 rounded-2xl font-bold text-sm text-gray-400 hover:text-black transition">
                    Cancelar
                </a>
                <button type="submit" 
                    class="w-full sm:w-auto px-12 py-4 bg-[#333333] text-white rounded-2xl font-bold text-sm uppercase tracking-widest hover:bg-black transition shadow-lg">
                    Crear Variante
                </button>
            </div>
        </form>
    </div>

    <!-- Nota informativa -->
    <div class="mt-8 p-6 bg-white/40 rounded-2xl border border-dashed border-gray-300 mx-2">
        <p class="text-[10px] md:text-xs text-gray-500 leading-relaxed text-center font-medium">
            <i class="fas fa-info-circle mr-1 text-inter-beige"></i>
            Las variantes permiten asignar fotos específicas a cada producto (por ejemplo, ver la tela en distintos colores).
        </p>
    </div>
</div>
@endsection