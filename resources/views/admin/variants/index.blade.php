@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-2 sm:px-4">
    <!-- Título Principal -->
    <div class="text-center mb-8 md:mb-12">
        <h1 class="text-2xl md:text-4xl font-bold border-b-2 border-black inline-block pb-2 px-6 md:px-12 uppercase tracking-tighter">
            Gestión de Variantes
        </h1>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-500 text-white rounded-2xl font-bold text-center shadow-lg animate-fade-in">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Barra de Filtros Funcional y Adaptable -->
    <div class="flex flex-col lg:flex-row justify-between items-center mb-8 gap-6 px-2">
        <form action="{{ route('admin.variants.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
            <!-- Búsqueda por nombre -->
            <div class="relative flex-1 sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar variante..." 
                    class="w-full bg-white border border-gray-200 px-4 py-3 rounded-xl text-sm focus:ring-2 focus:ring-admin-beige outline-none">
                <button type="submit" class="absolute right-3 top-3 text-gray-400">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <!-- Filtro Categoría -->
            <div class="relative flex-1 sm:w-48">
                <select name="category" onchange="this.form.submit()" 
                    class="w-full bg-[#C0B7B1] px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest focus:outline-none appearance-none cursor-pointer">
                    <option value="Todos">Todas las Categorías</option>
                    <option value="Base" {{ request('category') == 'Base' ? 'selected' : '' }}>Base</option>
                    <option value="Estampado" {{ request('category') == 'Estampado' ? 'selected' : '' }}>Estampado</option>
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-700">
                    <i class="fas fa-chevron-down mb-4 text-[10px]"></i>
                </div>
            </div>

            @if(request()->has('category') || request()->has('search'))
                <a href="{{ route('admin.variants.index') }}" class="text-[10px] text-gray-400 hover:text-red-500 font-black uppercase tracking-widest flex items-center justify-center sm:justify-start transition-colors">
                    Limpiar
                </a>
            @endif
        </form>

        <a href="{{ route('admin.variants.create') }}" class="w-full lg:w-auto bg-[#333333] text-white px-8 py-3.5 rounded-xl font-bold flex items-center justify-center space-x-2 hover:bg-black transition shadow-lg uppercase text-xs tracking-widest">
            <span> + Nueva Variante</span>
        </a>
    </div>

    <!-- Listado de Variantes -->
    <div class="bg-[#C0B7B1]/40 rounded-3xl md:rounded-3xl overflow-hidden shadow-sm border border-gray-100 mb-8">
        <table class="hidden md:table w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#333333] text-white uppercase text-[10px] tracking-widest font-bold">
                    <th class="px-12 py-4 text-center w-24">ID</th>
                    <th class="px-12 py-4">Variante</th>
                    <th class="px-12 py-4 text-center">Categoría</th>
                    <th class="px-12 py-4 text-center">Uso</th>
                    <th class="px-12 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/10">
                @forelse($variants as $variant)
                <tr class="hover:bg-white/30 transition-colors">
                    <td class="px-12 py-8 text-center font-bold text-xl text-gray-400">#{{ $variant->id }}</td>
                    <td class="px-12 py-8 text-xl font-bold text-gray-800">{{ $variant->name }}</td>
                    <td class="px-12 py-8 text-center">
                        <span class="bg-white/50 px-4 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-gray-700 border border-black/5">
                            {{ $variant->category }}
                        </span>
                    </td>
                    <td class="px-12 py-8 text-center font-medium text-lg">
                        <span class="font-bold text-gray-900">{{ $variant->products_count }}</span> <span class="text-sm text-gray-500 font-bold uppercase">Productos</span>
                    </td>
                    <td class="px-12 py-8 text-right space-x-2">
                        <a href="{{ route('admin.variants.edit', $variant->id) }}" class="inline-block bg-[#C0B7B1] p-3 rounded-xl text-gray-700 hover:bg-white transition shadow-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" 
                            onclick="confirmDeleteVariant('{{ route('admin.variants.destroy', $variant->id) }}')"
                            class="bg-[#333333] p-3 rounded-xl text-white hover:bg-red-600 transition shadow-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-12 py-32 text-center text-gray-400 italic">No hay registros</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Vista Mobile: Card Layout -->
        <div class="md:hidden divide-y divide-black/10">
            @forelse($variants as $variant)
                <div class="p-6 flex flex-col gap-4 hover:bg-white/20 transition-colors">
                    <div class="flex justify-between items-start">
                        <div class="min-w-0">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ $variant->category }}</span>
                            <p class="text-xl font-bold text-gray-800 leading-tight truncate">{{ $variant->name }}</p>
                            <p class="text-xs font-bold text-gray-500 mt-1 uppercase">En <span class="text-black">{{ $variant->products_count }}</span> productos</p>
                        </div>
                        <span class="text-xs font-bold text-gray-400">#{{ $variant->id }}</span>
                    </div>
                    
                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('admin.variants.edit', $variant->id) }}" class="flex-1 bg-[#C0B7B1] py-3 rounded-2xl text-gray-700 font-bold text-center text-sm shadow-sm flex items-center justify-center gap-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" 
                            onclick="confirmDeleteVariant('{{ route('admin.variants.destroy', $variant->id) }}')"
                            class="flex-1 bg-[#333333] py-3 rounded-2xl text-white font-bold text-center text-sm shadow-sm flex items-center justify-center gap-2">
                            <i class="fas fa-trash"></i> Borrar
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-400 italic font-bold">No se encontraron variantes.</div>
            @endforelse
        </div>
    </div>

    <!-- Paginación -->
    <div class="mt-8 px-4">
        {{ $variants->links('partials.pagination-es') }}
    </div>

    <!-- MODAL DE ELIMINACIÓN -->
    <div id="deleteVariantModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="relative bg-white rounded-3xl md:rounded-[2.5rem] shadow-2xl max-w-sm w-full p-8 md:p-10 text-center animate-fade-in mx-4">
            <div class="w-16 h-16 md:w-20 md:h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2 tracking-tighter">¿Eliminar variante?</h3>
            <p class="text-gray-500 text-xs md:text-sm mb-8 leading-relaxed">Se eliminará el vínculo de este color con todos los productos existentes.</p>
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button" onclick="closeDeleteModal()" class="w-full py-3 bg-gray-100 text-gray-600 font-bold rounded-2xl hover:bg-gray-200 transition order-2 sm:order-1 text-sm">Cancelar</button>
                <form id="deleteVariantForm" method="POST" class="w-full order-1 sm:order-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-3 bg-[#333333] text-white font-bold rounded-2xl hover:bg-red-600 transition text-sm shadow-lg">Sí, Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('deleteVariantModal');
    const form = document.getElementById('deleteVariantForm');

    function confirmDeleteVariant(url) {
        form.action = url;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") closeDeleteModal();
    });
</script>

<style>
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
</style>
@endsection