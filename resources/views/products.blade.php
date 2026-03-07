@extends('layouts.app')

@section('title', 'Catálogo de Productos')

@section('content')
    <div class="container mx-auto px-4 py-12 md:py-16">
        <!-- Título Principal Responsivo -->
        <div class="text-center mb-10 md:mb-16">
            <h1 class="text-3xl md:text-4xl font-bold border-b-2 border-black inline-block pb-2 uppercase tracking-tighter text-gray-800">
                Catálogo de Productos
            </h1>
        </div>

        <!-- Buscador y Filtros -->
        <div class="max-w-4xl mx-auto mb-16 space-y-8">
            <!-- Barra de Búsqueda -->
            <form action="{{ route('products') }}" method="GET" class="relative group">
                {{-- Mantenemos el filtro de composición si existe al buscar --}}
                @if(request('composition'))
                    <input type="hidden" name="composition" value="{{ request('composition') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Buscar producto por nombre..." 
                    class="w-full p-4 md:p-5 pl-6 md:pl-8 rounded-2xl border-none bg-white shadow-sm focus:ring-2 focus:ring-inter-dark outline-none text-sm md:text-base transition-all placeholder:text-gray-300">
                <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 bg-inter-dark text-white rounded-xl flex items-center justify-center hover:bg-black transition-colors">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- Filtros Rápidos (Fibras) -->
            <div class="flex flex-wrap justify-center gap-2 md:gap-3">
                <a href="{{ route('products', request()->only('search')) }}" 
                   class="{{ !request('composition') ? 'bg-inter-dark text-white' : 'bg-white text-gray-400 border border-gray-100' }} px-6 md:px-8 py-2 md:py-2.5 rounded-full text-[10px] md:text-xs font-bold uppercase tracking-widest hover:bg-[#333333] hover:text-white transition shadow-sm">
                   Todo
                </a>

                @if(isset($compositions))
                    @foreach($compositions as $comp)
                        <a href="{{ route('products', array_merge(request()->only('search'), ['composition' => $comp->id])) }}" 
                           class="{{ request('composition') == $comp->id ? 'bg-inter-dark text-white' : 'bg-white text-gray-400 border border-gray-100' }} px-6 md:px-8 py-2 md:py-2.5 rounded-full text-[10px] md:text-xs font-bold uppercase hover:bg-[#333333] hover:text-white transition shadow-sm">
                           {{ $comp->name }}
                        </a>
                    @endforeach
                @endif
            </div>

            {{-- Indicador de búsqueda activa --}}
            @if(request('search'))
                <div class="text-center">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">
                        Resultados para: <span class="text-inter-dark">"{{ request('search') }}"</span>
                        <a href="{{ route('products', request()->only('composition')) }}" class="ml-2 text-red-400 hover:text-red-600 transition-colors">
                            <i class="fas fa-times-circle"></i>
                        </a>
                    </p>
                </div>
            @endif
        </div>

        <!-- Grilla de Productos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
            @forelse($products as $product)
                <div class="group">
                    <div class="relative aspect-square bg-gray-100 rounded-[2rem] md:rounded-[2.5rem] overflow-hidden mb-6 shadow-sm border border-gray-100">
                        <!-- Imagen Principal -->
                        <img src="{{ asset('storage/' . $product->image) }}" 
                                class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                                onerror="this.src='https://via.placeholder.com/600x600?text=InterDiseño'">
                        
                        <!-- Iconos Flotantes (Visibles en hover) -->
                        <div class="absolute bottom-6 right-6 flex space-x-3">
                            <a href="https://wa.me/5491131011299?text=Hola, consulto por disponibilidad de: {{ $product->name }}" 
                                target="_blank"
                                class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all shadow-xl hover:bg-green-600">
                                <img src="{{ asset('img/icons/icono_whatsapp.png') }}" alt="WA" class="w-6 h-6">
                            </a>
                            <a href="{{ route('products.show', $product->slug) }}" 
                                class="w-12 h-12 bg-inter-dark text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all delay-75 shadow-xl hover:bg-black">
                                <i class="fas fa-plus text-lg"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Info Producto -->
                    <div class="px-2">
                        <h3 class="text-lg md:text-xl font-bold uppercase tracking-tight text-gray-800 leading-tight">{{ $product->name }}</h3>
                        
                        <p class="text-[9px] md:text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1 mb-4">
                            {{ $product->compositions->pluck('name')->join(' / ') ?: 'Nueva Colección' }}
                        </p>
                        
                        <div class="flex gap-2">
                            @if($product->stock)
                                <span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-[8px] font-black uppercase border border-green-100 tracking-widest">En Stock</span>
                            @else
                                <span class="bg-red-50 text-red-500 px-3 py-1 rounded-full text-[8px] font-black uppercase border border-red-100 tracking-widest">Sin Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <!-- Estado vacío -->
                <div class="col-span-full py-32 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-200">
                        <i class="fas fa-search text-3xl"></i>
                    </div>
                    <p class="text-gray-400 font-bold uppercase tracking-widest mb-4">No encontramos lo que buscás.</p>
                    <a href="{{ route('products') }}" class="text-inter-dark font-black text-xs uppercase border-b-2 border-inter-dark pb-1 hover:opacity-70 transition">Ver catálogo completo</a>
                </div>
            @endforelse
        </div>

        <!-- Paginación en Español (Adaptada) -->
        <div class="mt-20 md:mt-24 px-2">
            {{ $products->links('partials.pagination-es') }}
        </div>
    </div>
@endsection