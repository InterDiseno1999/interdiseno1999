@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-2 sm:px-4">
    <div class="text-center mb-8 md:mb-12">
        <h1 class="text-2xl md:text-4xl font-bold border-b-2 border-black inline-block pb-2 px-6 md:px-12 uppercase tracking-tighter">
            Gestión de Productos
        </h1>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-500 text-white rounded-2xl font-bold text-center shadow-lg animate-fade-in">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Barra de Filtros Funcional y Adaptable -->
    <div class="bg-white p-5 md:p-6 rounded-3xl md:rounded-[2rem] shadow-sm border border-gray-100 mb-8">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col gap-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
                <!-- Filtro por Stock -->
                <div class="space-y-1">
                    <label class="text-[9px] md:text-[10px] font-bold uppercase text-gray-400 ml-2">Disponibilidad</label>
                    <div class="relative">
                        <select name="stock" onchange="this.form.submit()" 
                            class="w-full bg-[#C0B7B1]/30 border-none px-4 py-3 rounded-xl font-semibold text-sm focus:ring-2 focus:ring-black outline-none cursor-pointer appearance-none">
                            <option value="">Todos los estados</option>
                            <option value="1" {{ request('stock') === '1' ? 'selected' : '' }}>En Stock</option>
                            <option value="0" {{ request('stock') === '0' ? 'selected' : '' }}>Sin Stock</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-[10px] pointer-events-none"></i>
                    </div>
                </div>

                <!-- Filtro por Composición -->
                <div class="space-y-1">
                    <label class="text-[9px] md:text-[10px] font-bold uppercase text-gray-400 ml-2">Composición</label>
                    <div class="relative">
                        <select name="composition" onchange="this.form.submit()" 
                            class="w-full bg-[#C0B7B1]/30 border-none px-4 py-3 rounded-xl font-semibold text-sm focus:ring-2 focus:ring-black outline-none cursor-pointer appearance-none">
                            <option value="">Todas las composiciones</option>
                            @if(isset($compositions))
                                @foreach($compositions as $comp)
                                    <option value="{{ $comp->id }}" {{ request('composition') == $comp->id ? 'selected' : '' }}>
                                        {{ $comp->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-[10px] pointer-events-none"></i>
                    </div>
                </div>

                <!-- Orden por Fecha -->
                <div class="space-y-1">
                    <label class="text-[9px] md:text-[10px] font-bold uppercase text-gray-400 ml-2">Ordenar por</label>
                    <div class="relative">
                        <select name="sort" onchange="this.form.submit()" 
                            class="w-full bg-[#C0B7B1]/30 border-none px-4 py-3 rounded-xl font-semibold text-sm focus:ring-2 focus:ring-black outline-none cursor-pointer appearance-none">
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Más nuevos primero</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Más antiguos</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-[10px] pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-gray-50 pt-4">
                @if(request()->anyFilled(['stock', 'composition', 'sort']))
                    <a href="{{ route('admin.products.index') }}" class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:underline">
                        Limpiar Filtros
                    </a>
                @else
                    <span></span>
                @endif
                
                <a href="{{ route('admin.products.create') }}" class="w-full sm:w-auto bg-[#333333] text-white px-8 py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-black transition shadow-lg uppercase text-xs tracking-widest">
                    <i class="fas fa-plus text-[10px]"></i>
                    <span>Nuevo Producto</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Contenedor de Productos -->
    <div class="bg-[#C0B7B1]/40 rounded-3xl md:rounded-3xl overflow-hidden shadow-sm border border-gray-100 mb-8">
        <table class="hidden lg:table w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#333333] text-white uppercase text-[10px] tracking-widest font-bold">
                    <th class="px-8 py-4">Producto</th>
                    <th class="px-8 py-4 text-center">Variantes / Fotos</th>
                    <th class="px-8 py-4 text-center">Estado</th>
                    <th class="px-8 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/10">
                @forelse($products as $product)
                <tr class="hover:bg-white/30 transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-200 shadow-sm flex-shrink-0">
                                <img src="{{ \Storage::disk('supabase')->url($product->image) }}" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/150'">
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-lg text-gray-900 leading-none truncate">{{ $product->name }}</p>
                                <p class="text-[10px] text-gray-500 font-bold uppercase mt-1 truncate">
                                    {{ $product->compositions->pluck('name')->join(' / ') ?: 'Sin composición' }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-gray-800">{{ $product->variants->count() }} Variantes</span>
                            <span class="text-[10px] text-gray-500 font-bold uppercase">
                                {{ $product->variants->whereNotNull('pivot.variant_image')->count() }} con imagen
                            </span>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-center">
                        @if($product->stock)
                            <span class="bg-[#10b981] text-white px-4 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-widest">En Stock</span>
                        @else
                            <span class="bg-red-400 text-white px-4 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-widest">Sin Stock</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right space-x-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-block bg-[#C0B7B1] p-3 rounded-xl text-gray-700 hover:bg-white transition shadow-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" 
                            onclick="confirmDelete('{{ route('admin.products.destroy', $product->id) }}')" 
                            class="bg-[#333333] p-3 rounded-xl text-white hover:bg-red-600 transition shadow-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-8 py-32 text-center text-gray-400 italic">No hay productos.</td></tr>
                @endforelse
            </tbody>
        </table>

        <!-- Vista Mobile: Card Layout -->
        <div class="lg:hidden divide-y divide-black/10">
            @forelse($products as $product)
                <div class="p-5 flex flex-col gap-4 hover:bg-white/20 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gray-100 flex-shrink-0 shadow-inner">
                            <img src="{{ \Storage::disk('supabase')->url($product->image) }}" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/150'">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-lg font-bold text-gray-800 truncate">{{ $product->name }}</h4>
                                @if($product->stock)
                                    <span class="w-2 h-2 bg-green-500 rounded-full mt-2"></span>
                                @else
                                    <span class="w-2 h-2 bg-red-500 rounded-full mt-2"></span>
                                @endif
                            </div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest truncate mb-2">
                                {{ $product->compositions->pluck('name')->join(' / ') ?: 'General' }}
                            </p>
                            <div class="flex gap-4">
                                <div class="text-[9px] font-bold text-gray-500 uppercase">
                                    <span class="text-gray-800">{{ $product->variants->count() }}</span> Variantes
                                </div>
                                <div class="text-[9px] font-bold text-gray-500 uppercase">
                                    <span class="text-gray-800">{{ $product->variants->whereNotNull('pivot.variant_image')->count() }}</span> Fotos
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex gap-2 pt-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="flex-1 bg-[#C0B7B1] py-3 rounded-2xl text-gray-700 font-bold text-center text-sm shadow-sm flex items-center justify-center gap-2">
                            <i class="fas fa-edit text-xs"></i> Editar
                        </a>
                        <button type="button" 
                            onclick="confirmDelete('{{ route('admin.products.destroy', $product->id) }}')"
                            class="flex-1 bg-[#333333] py-3 rounded-2xl text-white font-bold text-center text-sm shadow-sm flex items-center justify-center gap-2">
                            <i class="fas fa-trash text-xs"></i> Borrar
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-400 italic font-bold">No se encontraron productos.</div>
            @endforelse
        </div>
    </div>

    <!-- Paginación -->
    <div class="mt-8 px-4">
    {{ $products->links('partials.pagination-es') }}
    </div>

    <!-- Modal de Eliminación -->
    <div id="deleteModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="relative bg-white rounded-3xl md:rounded-[2.5rem] shadow-2xl max-w-sm w-full p-8 md:p-10 text-center animate-fade-in mx-4">
            <div class="w-16 h-16 md:w-20 md:h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl md:text-3xl">
                <i class="fas fa-trash"></i>
            </div>
            <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2 tracking-tighter">¿Eliminar producto?</h3>
            <p class="text-gray-500 text-xs md:text-sm mb-8 leading-relaxed px-4">Esta acción borrará el producto y todas las fotos asociadas permanentemente.</p>
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button" onclick="closeDeleteModal()" class="w-full py-3 bg-gray-100 text-gray-600 font-bold rounded-2xl hover:bg-gray-200 transition order-2 sm:order-1 text-sm">Cancelar</button>
                <form id="deleteProductForm" method="POST" class="w-full order-1 sm:order-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-3 bg-[#333333] text-white font-bold rounded-2xl hover:bg-red-600 transition text-sm shadow-lg">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteProductForm');

    function confirmDelete(url) {
        deleteForm.action = url;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") closeDeleteModal();
    });
</script>

<style>
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
</style>
@endsection