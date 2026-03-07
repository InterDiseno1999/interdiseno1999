@extends('layouts.admin')

@section('title', 'Administración del Sistema')

@section('content')
<div class="max-w-6xl mx-auto px-2 sm:px-4">
    <!-- Título Principal -->
    <div class="text-center mb-8 md:mb-16">
        <h1 class="text-2xl md:text-4xl font-bold border-b-2 border-black inline-block pb-2 px-6 md:px-12 uppercase tracking-tighter">
            Administración del Sistema
        </h1>
    </div>

    <!-- Cajas de Resumen (Grilla Adaptable) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10 md:mb-16">
        <!-- Gestión de Composiciones -->
        <a href="{{ route('admin.compositions.index') }}" class="group bg-admin-beige p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-xl hover:bg-admin-beige/20 transition-all duration-500">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-admin-dark rounded-xl flex items-center justify-center p-2 group-hover:scale-110 transition-transform flex-shrink-0">
                <img src="{{ asset('img/icons/icono_composiciones.png') }}" alt="Icono Composiciones" class="w-full h-full object-contain">
            </div>
            <div class="min-w-0">
                <p class="text-[9px] md:text-[10px] font-bold text-black uppercase leading-none mb-1 truncate">Composiciones</p>
                <p class="text-xs md:text-sm font-bold text-gray-800">{{ $compositionsCount ?? 0 }} Registradas</p>
            </div>
        </a>

        <!-- Gestión de Productos -->
        <a href="{{ route('admin.products.index') }}" class="group bg-admin-beige p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-xl hover:bg-admin-beige/20 transition-all duration-500">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-admin-dark rounded-xl flex items-center justify-center p-2 group-hover:scale-110 transition-transform flex-shrink-0">
                <img src="{{ asset('img/icons/icono_productos.png') }}" alt="Icono Productos" class="w-full h-full object-contain">
            </div>
            <div class="min-w-0">
                <p class="text-[9px] md:text-[10px] font-bold text-black uppercase leading-none mb-1 truncate">Productos</p>
                <p class="text-xs md:text-sm font-bold text-gray-800">{{ $productsCount ?? 0 }} Publicados</p>
            </div>
        </a>

        <!-- Gestión de Video -->
        <a href="{{ route('admin.video.edit') }}" class="group bg-admin-beige p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-xl hover:bg-admin-beige/20 transition-all duration-500">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-admin-dark rounded-xl flex items-center justify-center p-2 group-hover:scale-110 transition-transform flex-shrink-0">
                <img src="{{ asset('img/icons/icono_video.png') }}" alt="Icono Multimedia" class="w-full h-full object-contain">
            </div>
            <div class="min-w-0">
                <p class="text-[9px] md:text-[10px] font-bold text-black uppercase leading-none mb-1 truncate">Multimedia</p>
                <p class="text-xs md:text-sm font-bold text-gray-800">Video</p>
            </div>
        </a>

        <!-- Gestión de Variantes -->
        <a href="{{ route('admin.variants.index') }}" class="group bg-admin-beige p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-xl hover:bg-admin-beige/20 transition-all duration-500">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-admin-dark rounded-xl flex items-center justify-center p-2 group-hover:scale-110 transition-transform flex-shrink-0">
                <img src="{{ asset('img/icons/icono_variantes.png') }}" alt="Icono Variantes" class="w-full h-full object-contain">
            </div>
            <div class="min-w-0">
                <p class="text-[9px] md:text-[10px] font-bold text-black uppercase leading-none mb-1 truncate">Variantes</p>
                <p class="text-xs md:text-sm font-bold text-gray-800">Colores</p>
            </div>
        </a>
    </div>

    <!-- Contenedor Principal de Últimos Productos -->
    <div class="bg-white rounded-3xl md:rounded-[2.5rem] p-5 md:p-12 border border-gray-100 shadow-xl min-h-[400px]">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 md:mb-12 border-b border-gray-100 pb-6 gap-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight text-center sm:text-left">Últimos Productos</h2>
            <div class="flex items-center space-x-3 w-full sm:w-auto justify-center">
                <a href="{{ route('admin.products.create') }}" class="flex-1 sm:flex-none text-center bg-admin-dark text-white px-4 md:px-6 py-2.5 rounded-xl font-bold text-[10px] md:text-xs uppercase tracking-widest hover:bg-black transition shadow-md">+ Nuevo Producto</a>
                <a href="{{ route('admin.products.index') }}" class="flex-1 sm:flex-none text-center text-gray-400 hover:text-black font-bold uppercase text-[9px] md:text-[10px] tracking-widest transition-colors">Ver todos</a>
            </div>
        </div>

        <!-- Listado de Productos Recientes -->
        <div class="space-y-4 md:space-y-6">
            @forelse($products ?? [] as $product)
                <div class="flex flex-col md:flex-row items-center justify-between p-4 md:p-6 border border-gray-50 hover:bg-gray-50/50 transition-all duration-300 rounded-2xl md:rounded-[2rem] group shadow-sm gap-4">
                    <div class="flex flex-col md:flex-row items-center md:items-center space-y-3 md:space-y-0 md:space-x-6 w-full">
                        <!-- Miniatura (SOPORTE SUPABASE) -->
                        <div class="w-24 h-24 md:w-20 md:h-20 rounded-2xl overflow-hidden shadow-inner bg-gray-100 flex-shrink-0">
                            {{-- Cambiado para usar el disco de Supabase --}}
                            <img src="{{ \Storage::disk('supabase')->url($product->image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" onerror="this.src='https://via.placeholder.com/150'">
                        </div>
                        <!-- Info -->
                        <div class="text-center md:text-left w-full overflow-hidden">
                            <h4 class="text-lg md:text-xl font-bold text-gray-800 leading-tight truncate">{{ $product->name }}</h4>
                            <p class="text-[9px] md:text-[10px] font-bold uppercase text-gray-400 mt-1 tracking-widest truncate">
                                {{ $product->compositions->pluck('name')->join(' / ') ?: 'Sin composición' }}
                            </p>
                            <div class="mt-2 flex justify-center md:justify-start">
                                @if($product->stock)
                                    <span class="bg-green-100 text-green-600 px-3 py-0.5 rounded-full text-[8px] md:text-[9px] font-black uppercase tracking-tighter">En Stock</span>
                                @else
                                    <span class="bg-red-100 text-red-600 px-3 py-0.5 rounded-full text-[8px] md:text-[9px] font-black uppercase tracking-tighter">Sin Stock</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="flex items-center justify-center space-x-3 w-full md:w-auto border-t md:border-none pt-4 md:pt-0">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="flex-1 md:flex-none w-12 h-12 md:w-10 md:h-10 bg-admin-beige text-gray-600 rounded-xl flex items-center justify-center hover:bg-[#333333] hover:text-white transition-all shadow-sm">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <button type="button" 
                            onclick="confirmDelete('{{ route('admin.products.destroy', $product->id) }}')" 
                            class="flex-1 md:flex-none w-12 h-12 md:w-10 md:h-10 bg-admin-beige text-gray-600 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-16 text-center space-y-4">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-200">
                        <i class="fas fa-box-open text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-700">No hay productos</h3>
                        <p class="text-gray-400 text-xs">Comienza creando tu primer estampado.</p>
                    </div>
                    <a href="{{ route('admin.products.create') }}" class="mt-4 px-6 py-3 bg-admin-beige text-admin-dark font-bold rounded-xl hover:bg-admin-dark hover:text-white transition-all shadow-md text-xs uppercase tracking-widest">
                        Crear Producto
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal de Eliminación (Adaptado a móviles) -->
<div id="deleteModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="relative bg-white rounded-3xl md:rounded-[2.5rem] shadow-2xl max-w-sm w-full p-8 md:p-10 text-center animate-fade-in mx-4">
        <div class="w-16 h-16 md:w-20 md:h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl md:text-3xl">
            <i class="fas fa-trash"></i>
        </div>
        <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">¿Eliminar?</h3>
        <p class="text-gray-500 text-xs md:text-sm mb-8">Esta acción borrará el producto y sus variantes permanentemente.</p>
        <div class="flex flex-col sm:flex-row gap-3">
            <button type="button" onclick="closeDeleteModal()" class="w-full py-3 px-6 bg-gray-100 text-gray-600 font-bold rounded-2xl hover:bg-gray-200 transition order-2 sm:order-1 text-sm">Cancelar</button>
            <form id="deleteProductForm" method="POST" class="w-full order-1 sm:order-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-3 px-6 bg-[#333333] text-white font-bold rounded-2xl hover:bg-red-600 transition text-sm">Eliminar</button>
            </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteProductForm');

    function confirmDelete(url) {
        deleteForm.action = url;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Evitar scroll de fondo
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
    .animate-fade-in { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
    
    /* Mejoras de accesibilidad en touch */
    @media (max-width: 640px) {
        .group:active {
            background-color: rgba(0, 0, 0, 0.05);
        }
    }
</style>
@endsection