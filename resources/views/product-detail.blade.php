@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container mx-auto px-4 py-16">
    <!-- Fila Principal: Imagen y Detalles -->
    <div class="flex flex-col lg:flex-row gap-16 items-start justify-center">
        
        <!-- Columna Izquierda: Imagen (SOPORTE SUPABASE) -->
        <div class="lg:w-[42%] w-full space-y-8">
            <div class="bg-gray-50 rounded-[2rem] overflow-hidden aspect-square shadow-md border border-gray-100 group relative max-w-md mx-auto lg:mx-0 mt-2">
                {{-- Imagen principal desde Supabase --}}
                <img id="main-product-image" 
                     src="{{ \Storage::disk('supabase')->url($product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover transition-all duration-500 group-hover:scale-[1.02]">
            </div>

            <!-- Menús Desplegables -->
            <div class="flex flex-col sm:flex-row gap-6 max-w-md mx-auto lg:mx-0">
                <!-- Desplegable de Variantes -->
                <div class="flex-1 group">
                    <button type="button" 
                            onclick="toggleDropdown('variants-list', 'variants-chevron')"
                            class="w-full bg-inter-beige border border-gray-100 p-4 flex justify-center items-center rounded-2xl text-inter-dark shadow-sm hover:shadow-md transition-all outline-none relative">
                        <div class="flex items-center gap-3">
                            <span class="font-bold uppercase text-sm tracking-[0.15em]">Variantes</span>
                        </div>
                        <i id="variants-chevron" class="fas fa-chevron-down text-xs text-inter-dark transition-transform duration-300 absolute right-6"></i>
                    </button>
                    <div id="variants-list" class="hidden mt-2 flex flex-col bg-inter-beige border border-gray-50 rounded-2xl shadow-xl overflow-hidden max-h-64 overflow-y-auto animate-fade-in-down">
                        @forelse($product->variants->where('category', 'Base') as $variant)
                            <button type="button" 
                                    class="variant-option w-full text-left px-5 py-3.5 text-xs font-medium transition-all hover:bg-inter-dark hover:text-white border-b border-white/20 last:border-none"
                                    {{-- Data attribute con URL de Supabase --}}
                                    data-image="{{ $variant->pivot->variant_image ? \Storage::disk('supabase')->url($variant->pivot->variant_image) : \Storage::disk('supabase')->url($product->image) }}"
                                    data-name="{{ $variant->name }}"
                                    onclick="updateProductGallery(this, 'variant-option')">
                                {{ $variant->name }}
                            </button>
                        @empty
                            <div class="px-5 py-4 text-[11px] font-bold uppercase text-gray-500 italic bg-gray-50/30">
                                Color Único
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Desplegable de Diseño -->
                <div class="flex-1 group">
                    <button type="button" 
                            onclick="toggleDropdown('design-list', 'design-chevron')"
                            class="w-full bg-inter-beige border border-gray-100 p-4 flex justify-center items-center rounded-2xl text-inter-dark shadow-sm hover:shadow-md transition-all outline-none relative">
                        <div class="flex items-center gap-3">
                            <span class="font-bold uppercase text-sm tracking-[0.15em]">Diseño</span>
                        </div>
                        <i id="design-chevron" class="fas fa-chevron-down text-xs text-inter-dark transition-transform duration-300 absolute right-6"></i>
                    </button>
                    <div id="design-list" class="hidden mt-2 flex flex-col bg-inter-beige border border-gray-50 rounded-2xl shadow-xl overflow-hidden animate-fade-in-down">
                        @if($product->has_design && $product->variants->where('category', 'Estampado')->count() > 0)
                            @foreach($product->variants->where('category', 'Estampado') as $design)
                                <button type="button" 
                                        class="design-option w-full text-left px-5 py-3.5 text-xs font-medium transition-all hover:bg-inter-dark hover:text-white border-b border-white/20 last:border-none"
                                        {{-- Data attribute con URL de Supabase --}}
                                        data-image="{{ $design->pivot->variant_image ? \Storage::disk('supabase')->url($design->pivot->variant_image) : \Storage::disk('supabase')->url($product->image) }}"
                                        data-name="{{ $design->name }}"
                                        onclick="updateProductGallery(this, 'design-option')">
                                    {{ $design->name }}
                                </button>
                            @endforeach
                        @else
                            <div class="px-5 py-4 text-[11px] font-bold uppercase text-gray-500 italic bg-gray-50/30">
                                Diseño Único
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex justify-center sm:justify-start max-w-md mx-auto lg:mx-0">
                <button onclick="resetGallery()" class="group flex items-center gap-2 px-8 py-2.5 bg-gray-50 text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-inter-dark hover:bg-white border border-transparent hover:border-gray-200 rounded-full transition-all">
                    <i class="fas fa-sync-alt text-[9px] group-hover:rotate-180 transition-transform duration-500"></i>
                    Limpiar Filtros
                </button>
            </div>
        </div>

        <!-- Columna Derecha: Información -->
        <div class="lg:w-[50%] w-full space-y-10 lg:pt-4">
            <div class="space-y-4">
                <h1 class="text-6xl font-bold text-inter-dark tracking-tighter leading-tight">{{ $product->name }}</h1>
                <div class="w-20 h-1 bg-inter-beige rounded-full"></div>
            </div>

            <div class="flex items-baseline gap-6">         
                @if($product->stock)
                    <div class="flex items-center gap-2 bg-green-50 text-green-600 px-4 py-1 rounded-full border border-green-100">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-sm font-black uppercase tracking-widest">Disponible</span>
                    </div>
                @else
                    <div class="flex items-center gap-2 bg-red-50 text-red-500 px-4 py-1 rounded-full border border-red-100">
                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                        <span class="text-sm font-black uppercase tracking-widest">Sin Stock</span>
                    </div>
                @endif
            </div>

            <div class="bg-white/50 backdrop-blur-sm p-8 rounded-[2rem] border border-gray-100 shadow-sm">
                <div class="text-gray-500 text-base leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 py-4 border-y border-gray-100">
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Ancho Útil</p>
                    <p class="text-lg font-bold text-inter-dark">{{ $product->width }} <span class="text-sm font-normal text-gray-400">metros</span></p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Composición</p>
                    <p class="text-lg font-bold text-inter-dark">
                        {{ $product->compositions->count() > 0 ? $product->compositions->pluck('name')->join(' / ') : 'Colección ID' }}
                    </p>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex flex-col sm:flex-row gap-5 pt-4">
                <a id="whatsapp-link"
                   href="https://wa.me/5491131011299?text=Hola, consulto por disponibilidad de: {{ $product->name }}" 
                   target="_blank"
                   class="flex-[2] bg-green-500 text-white py-5 rounded-2xl font-bold uppercase text-[11px] tracking-[0.2em] flex items-center justify-center gap-4 hover:bg-[#4fa753] hover:shadow-xl hover:-translate-y-1 transition-all">
                   <img src="{{ asset('img/icons/icono_whatsapp.png') }}" alt="Whatsapp" class="w-7 h-7">
                   <span>Consultar stock</span>
                </a>
                <a href="{{ route('products') }}" 
                   class="flex-1 bg-inter-dark text-white py-5 rounded-2xl font-bold uppercase text-[11px] tracking-[0.2em] justify-center flex items-center text-center hover:bg-black hover:shadow-xl hover:-translate-y-1 transition-all">
                    Volver a Productos
                </a>
            </div>
        </div>
    </div>

    <!-- Sección: Recomendados (SOPORTE SUPABASE) -->
    <div class="mt-40">
        <div class="flex justify-between items-end mb-12">
            <div>
                <p class="text-[10px] font-bold text-inter-beige uppercase tracking-[0.3em] mb-2">Descubrí más</p>
                <h2 class="text-5xl font-bold text-inter-dark tracking-tighter text-center md:text-left">También te puede interesar</h2>
            </div>
            <a href="{{ route('products') }}" class="hidden md:block text-[10px] font-bold uppercase tracking-widest border-b-2 border-inter-beige pb-1 hover:text-inter-beige transition-colors">Ver catálogo completo</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach($recommended as $item)
                <div class="group cursor-pointer" onclick="window.location='{{ route('products.show', $item->slug) }}'">
                    <div class="relative aspect-square bg-gray-50 rounded-[2.5rem] overflow-hidden mb-6 shadow-sm border border-gray-100">
                        {{-- Recomendados desde Supabase --}}
                        <img src="{{ \Storage::disk('supabase')->url($item->image) }}" 
                             alt="{{ $item->name }}" 
                             class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0">
                        
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center">
                            <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center text-inter-dark transform scale-50 group-hover:scale-100 transition-all duration-500 shadow-2xl">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-1 px-2">
                        <h3 class="font-bold text-inter-dark uppercase text-sm tracking-tight group-hover:text-inter-beige transition-colors">{{ $item->name }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                            {{ $item->compositions->pluck('name')->join(' / ') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    const mainImg = document.getElementById('main-product-image');
    const whatsappLink = document.getElementById('whatsapp-link');
    {{-- URL base para resetear galeria --}}
    const originalSrc = "{{ \Storage::disk('supabase')->url($product->image) }}";
    const productName = "{{ $product->name }}";
    
    let selectedVariant = "";
    let selectedDesign = "";

    function toggleDropdown(listId, chevronId) {
        const list = document.getElementById(listId);
        const chevron = document.getElementById(chevronId);
        
        if (listId === 'variants-list') {
            document.getElementById('design-list').classList.add('hidden');
            document.getElementById('design-chevron').style.transform = 'rotate(0deg)';
        } else {
            document.getElementById('variants-list').classList.add('hidden');
            document.getElementById('variants-chevron').style.transform = 'rotate(0deg)';
        }

        if (list.classList.contains('hidden')) {
            list.classList.remove('hidden');
            chevron.style.transform = 'rotate(180deg)';
        } else {
            list.classList.add('hidden');
            chevron.style.transform = 'rotate(0deg)';
        }
    }

    function updateWhatsAppLink() {
        let baseMsg = `Hola, consulto por disponibilidad de: ${productName}`;
        if (selectedVariant) baseMsg += ` - Color: ${selectedVariant}`;
        if (selectedDesign) baseMsg += ` - Diseño: ${selectedDesign}`;

        const encodedMsg = encodeURIComponent(baseMsg);
        whatsappLink.href = `https://wa.me/5491131011299?text=${encodedMsg}`;
    }

    function updateProductGallery(element, className) {
        const newSrc = element.getAttribute('data-image');
        const name = element.getAttribute('data-name');
        
        if (className === 'variant-option') selectedVariant = name;
        else if (className === 'design-option') selectedDesign = name;

        updateWhatsAppLink();
        
        mainImg.style.filter = 'blur(10px)';
        mainImg.style.opacity = '0.5';
        
        setTimeout(() => {
            mainImg.src = newSrc;
            mainImg.style.filter = 'blur(0)';
            mainImg.style.opacity = '1';

            document.querySelectorAll('.' + className).forEach(btn => {
                btn.classList.remove('bg-inter-dark', 'text-white');
            });

            element.classList.add('bg-inter-dark', 'text-white');
        }, 300);
    }

    function resetGallery() {
        selectedVariant = "";
        selectedDesign = "";
        updateWhatsAppLink();

        mainImg.style.filter = 'blur(10px)';
        mainImg.style.opacity = '0.5';
        
        setTimeout(() => {
            mainImg.src = originalSrc;
            mainImg.style.filter = 'blur(0)';
            mainImg.style.opacity = '1';
            
            document.querySelectorAll('.variant-option, .design-option').forEach(btn => {
                btn.classList.remove('bg-inter-dark', 'text-white');
            });

            document.getElementById('variants-list').classList.add('hidden');
            document.getElementById('design-list').classList.add('hidden');
            document.getElementById('variants-chevron').style.transform = 'rotate(0deg)';
            document.getElementById('design-chevron').style.transform = 'rotate(0deg)';
        }, 300);
    }
</script>

<style>
    body { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
    .overflow-y-auto::-webkit-scrollbar { width: 5px; }
    .overflow-y-auto::-webkit-scrollbar-track { background: #f9f9f9; }
    .overflow-y-auto::-webkit-scrollbar-thumb { background: #C0B7B1; border-radius: 10px; }
    
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down { animation: fadeInDown 0.3s ease-out forwards; }
</style>
@endsection