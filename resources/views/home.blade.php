@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <!-- 1. CARRUSEL HERO (VANILLA JS) -->
    <section class="relative overflow-hidden bg-gray-200" id="hero-carousel">
        <div class="relative h-[450px] md:h-[650px] w-full" id="carousel-inner">
            <!-- Slide 1: Título Principal -->
            <div class="carousel-item absolute inset-0 opacity-100 transition-opacity duration-1000 ease-in-out z-10">
                <img src="{{ asset('img/home/carrusel_1.png') }}" alt="Slide 1" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center text-center p-4">
                    <div class="max-w-4xl">
                        <h2 class="text-4xl md:text-7xl font-bold text-white tracking-tighter uppercase drop-shadow-lg leading-none">
                            Telas de tapicería<br>y decoración
                        </h2>
                        <div class="w-24 h-1.5 bg-inter-beige mx-auto mt-6 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Texto Secundario -->
            <div class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                <img src="{{ asset('img/home/carrusel_2.JPG') }}" alt="Slide 2" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center p-4">
                    <div class="max-w-2xl">
                        <h3 class="text-2xl md:text-5xl font-bold text-white tracking-tight uppercase drop-shadow-md">
                             La calidad de nuestros generos comienza con las fibras
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Texto Secundario -->
            <div class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                <img src="{{ asset('img/home/carrusel_3.png') }}" alt="Slide 3" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center p-4">
                    <div class="max-w-2xl">
                        <h3 class="text-2xl md:text-5xl font-bold text-white tracking-tight uppercase drop-shadow-md">
                            Generos que enamoran
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Slide 4: Texto Secundario -->
            <div class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                <img src="{{ asset('img/home/carrusel_4.JPG') }}" alt="Slide 4" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center p-4">
                    <div class="max-w-2xl">
                        <h3 class="text-2xl md:text-5xl font-bold text-white tracking-tight uppercase drop-shadow-md">
                            Mas 25 años tejiendo nuevos proyectos
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Slide 5 -->
            <div class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                <img src="{{ asset('img/home/carrusel_5.png') }}" alt="Slide 5" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center p-4">
                    <div class="max-w-2xl">
                        <h3 class="text-2xl md:text-5xl font-bold text-white tracking-tight uppercase drop-shadow-md">
                            Explore la sensación del tacto
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controles: Flechas -->
        <button id="prevBtn" class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white flex items-center justify-center hover:bg-white hover:text-inter-dark transition-all z-20 hidden md:flex">
            <i class="fas fa-chevron-left text-sm"></i>
        </button>
        <button id="nextBtn" class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white flex items-center justify-center hover:bg-white hover:text-inter-dark transition-all z-20 hidden md:flex">
            <i class="fas fa-chevron-right text-sm"></i>
        </button>

        <!-- Indicadores (Dots) -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex gap-3 z-20" id="carousel-dots">
            <button class="dot h-1.5 rounded-full transition-all duration-500 shadow-sm bg-white w-10" data-index="0"></button>
            <button class="dot h-1.5 rounded-full transition-all duration-500 shadow-sm bg-white/40 w-3" data-index="1"></button>
            <button class="dot h-1.5 rounded-full transition-all duration-500 shadow-sm bg-white/40 w-3" data-index="2"></button>
            <button class="dot h-1.5 rounded-full transition-all duration-500 shadow-sm bg-white/40 w-3" data-index="3"></button>
            <button class="dot h-1.5 rounded-full transition-all duration-500 shadow-sm bg-white/40 w-3" data-index="4"></button>
        </div>
    </section>

    <!-- 2. SOBRE NOSOTROS -->
    <section class="container mx-auto px-4 py-20">
        <div class="flex flex-col md:flex-row gap-12 lg:gap-20 items-start">
            <div class="md:w-1/2 space-y-6">
                <h2 class="text-3xl md:text-4xl font-bold border-b-2 border-black pb-3 tracking-tighter uppercase">Sobre Nosotros</h2>
                <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                    Somos una empresa textil con más de 25 años en el sector del interiorismo. Inspirados por la pasión en el diseño y fieles a nuestros valores comercializamos y desarrollamos <span class="font-bold text-inter-dark uppercase">Géneros diferenciados para tapizar y decorar</span>, a través de un equipo de trabajo de talento, motivados por la superación constante de nuestros objetivos. 
                </p>
                <div class="w-full aspect-video bg-gray-100 rounded-3xl shadow-sm overflow-hidden border border-gray-50">
                    <img src="{{ asset('img/home/sobre_nosotros_1.JPG') }}" alt="Taller InterDiseño" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="md:w-1/2 space-y-8">
                <div class="w-full h-[350px] md:h-[450px] bg-gray-100 rounded-[2.5rem] shadow-xl overflow-hidden border-8 border-white">
                    <img src="{{ asset('img/home/sobre_nosotros_2.JPG') }}" alt="Showroom InterDiseño" class="w-full h-full object-cover">
                </div>
                <div class="space-y-6">
                    <p class="text-gray-500 leading-relaxed italic border-l-4 border-inter-beige pl-6 text-sm md:text-base">
                        Nuestra trayectoria nos permite entender que cada ambiente cuenta una historia, por lo que nos esforzamos en ser el aliado estratégico que materializa la visión de cada decorador arquitecto o fabricante, integrando procesos que aseguran calidad en cada metro de tela entregado.
                    </p> 
                </div>
            </div>
        </div>
    </section>

    <!-- 3. PRODUCTOS DESTACADOS (SOPORTE SUPABASE) -->
    <section class="container mx-auto px-4 py-24 border-t border-gray-50">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold border-b-2 border-gray-100 inline-block pb-2 tracking-tighter uppercase">Productos destacados</h2>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
            @forelse($products as $product)
                <div class="group cursor-pointer" onclick="window.location='{{ route('products.show', $product['slug'] ?? '#') }}'">
                    <div class="aspect-square bg-gray-100 rounded-[2.5rem] overflow-hidden relative shadow-sm border border-gray-100">
                        <img src="{{ \Storage::disk('supabase')->url($product['image'] ?? '') }}" 
                                class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 scale-105 group-hover:scale-100"
                                onerror="this.src='https://via.placeholder.com/600x600?text=InterDiseño'">
                        
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center backdrop-blur-[2px]">
                            <span class="text-white text-[10px] font-black border-2 border-white px-6 py-3 uppercase tracking-[0.2em] transform translate-y-4 group-hover:translate-y-0 transition-transform">Ver Detalle</span>
                        </div>
                    </div>
                    <div class="px-2">
                        <h3 class="mt-6 font-bold text-base uppercase tracking-tight text-gray-800">{{ $product['name'] ?? 'Producto' }}</h3>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">
                            {{ !empty($product['compositions']) ? collect($product['compositions'])->pluck('name')->join(' / ') : 'Nueva Colección' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 font-bold uppercase tracking-widest italic">Explorando nuevas texturas...</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 4. SERVICIOS -->
    <section class="bg-gray-50 py-24">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold border-b-2 border-inter-dark pb-3 inline-block mb-20 tracking-tighter uppercase">Nuestros Servicios</h2>
            
            <div class="grid md:grid-cols-3 gap-8 lg:gap-12 text-left">
                <!-- Tarjeta 1 -->
                <div class="group bg-white rounded-[2.5rem] shadow-sm hover:shadow-2xl transition-all duration-700 overflow-hidden flex flex-col border border-gray-100">
                    <div class="h-60 overflow-hidden relative">
                        <img src="{{ asset('img/home/servicios_1.png') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/10"></div>
                    </div>
                    <div class="p-10 space-y-4">
                        <h3 class="font-bold text-gray-800 text-xl tracking-tight uppercase">Atención Personalizada</h3>
                        <p class="text-gray-400 text-xs leading-relaxed font-medium">Nuestro call center atiende inquietudes agilizando la gestión comercial: disponibilidad, fechas de entrega y seguimiento de pedidos.</p>
                    </div>
                </div>

                <!-- Tarjeta 2 -->
                <div class="group bg-white rounded-[2.5rem] shadow-sm hover:shadow-2xl transition-all duration-700 overflow-hidden flex flex-col border border-gray-100">
                    <div class="h-60 overflow-hidden relative">
                        <img src="{{ asset('img/home/servicios_2.JPG') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/10"></div>
                    </div>
                    <div class="p-10 space-y-4">
                        <h3 class="font-bold text-gray-800 text-xl tracking-tight uppercase">Ventas</h3>
                        <p class="text-gray-400 text-xs leading-relaxed font-medium">Asesoramiento comercial en showroom o mediante visitas de nuestros vendedores especializados en su empresa.</p>
                    </div>
                </div>

                <!-- Tarjeta 3 -->
                <div class="group bg-white rounded-[2.5rem] shadow-sm hover:shadow-2xl transition-all duration-700 overflow-hidden flex flex-col border border-gray-100">
                    <div class="h-60 overflow-hidden relative">
                        <img src="{{ asset('img/home/servicios_3.jpg') }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/10"></div>
                    </div>
                    <div class="p-10 space-y-4 text-center md:text-left">
                        <h3 class="font-bold text-gray-800 text-xl tracking-tight uppercase text-center md:text-left">Logística</h3>
                        <p class="text-gray-400 text-xs leading-relaxed font-medium">Distribución eficiente en CABA y GBA con repartos programados optimizados según su operatoria comercial.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. SECCIÓN DE VIDEO (OPTIMIZADA: SOPORTE MOV Y SONIDO ACTIVADO) -->
    <section class="py-12 md:py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto aspect-video bg-inter-dark relative overflow-hidden rounded-[2.5rem] shadow-2xl border-4 border-white group cursor-pointer" id="mainVideoContainer">
                
                @php
                    $videoDirectory = 'assets/video';
                    $baseName = 'home_background_video';
                    $allFiles = \Storage::disk('supabase')->files($videoDirectory);
                    // Buscamos el archivo que coincida con el nombre base sin importar la extensión
                    $currentVideoPath = collect($allFiles)->first(fn($f) => str_contains($f, $baseName));
                    $isVideoMov = $currentVideoPath ? (Str::afterLast($currentVideoPath, '.') === 'mov') : false;
                @endphp

                @if($currentVideoPath)
                    {{-- Hemos eliminado 'muted' para habilitar el sonido al hacer clic --}}
                    <video id="homeMainVideo" class="absolute inset-0 w-full h-full object-cover" loop playsinline>
                        <source src="{{ \Storage::disk('supabase')->url($currentVideoPath) }}?v={{ time() }}" 
                                type="video/{{ $isVideoMov ? 'quicktime' : 'mp4' }}">
                    </video>
                    
                    <div id="mainVideoOverlay" class="absolute inset-0 bg-black/30 flex flex-col items-center justify-center z-10 transition-all duration-700">
                        <div class="w-20 h-20 md:w-24 md:h-24 border-2 border-white rounded-full flex items-center justify-center bg-white/10 backdrop-blur-md transition-transform group-hover:scale-110 shadow-2xl">
                            <i id="mainPlayIcon" class="fas fa-play text-white text-3xl ml-1"></i>
                        </div>
                        <div class="absolute bottom-8 left-8 right-8 z-20 flex justify-between items-end transition-opacity" id="mainVideoLabels">
                            <div class="text-white">
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] opacity-60 mb-1">Producción Propia</p>
                                <h3 class="text-lg md:text-2xl font-bold tracking-tighter">Calidad con sonido</h3>
                            </div>
                            <p class="text-[9px] font-black text-white/40 uppercase tracking-widest hidden md:block">Clic para ver y escuchar</p>
                        </div>
                    </div>
                @else
                    <div class="absolute inset-0 bg-[#333] flex flex-col items-center justify-center text-white/30 p-10 text-center">
                        <i class="fas fa-video-slash text-6xl mb-4 opacity-20"></i>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em]">No hay video cargado</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- 6. MÉTRICAS -->
    <section class="bg-inter-dark text-white py-24 overflow-hidden" id="metrics-section">
        <div class="container mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-12 md:gap-8 text-center">
            <div class="flex flex-col items-center space-y-5">
                <div class="w-14 h-14">
                    <img src="{{ asset('img/icons/icono_diseno.png') }}" class="w-full h-full object-contain filter invert opacity-80">
                </div>
                <div>
                    <p class="text-4xl font-bold counter tracking-tighter" data-target="100">0</p>
                    <p class="text-[9px] text-inter-beige uppercase font-black tracking-[0.3em] mt-1">Diseños</p>
                </div>
            </div>
            <div class="flex flex-col items-center space-y-5">
                <div class="w-14 h-14">
                    <img src="{{ asset('img/icons/icono_clientes.png') }}" class="w-full h-full object-contain filter invert opacity-80">
                </div>
                <div>
                    <p class="text-4xl font-bold counter tracking-tighter" data-target="3000">0</p>
                    <p class="text-[9px] text-inter-beige uppercase font-black tracking-[0.3em] mt-1">Clientes</p>
                </div>
            </div>
            <div class="flex flex-col items-center space-y-5">
                <div class="w-14 h-14">
                    <img src="{{ asset('img/icons/icono_stock.png') }}" class="w-full h-full object-contain filter invert opacity-80">
                </div>
                <div>
                    <p class="text-4xl font-bold counter tracking-tighter" data-target="5500">0</p>
                    <p class="text-[9px] text-inter-beige uppercase font-black tracking-[0.3em] mt-1">Stock (Mts)</p>
                </div>
            </div>
            <div class="flex flex-col items-center space-y-5">
                <div class="w-14 h-14">
                    <img src="{{ asset('img/icons/icono_anos.png') }}" class="w-full h-full object-contain filter invert opacity-80">
                </div>
                <div>
                    <p class="text-4xl font-bold counter tracking-tighter" data-target="25">0</p>
                    <p class="text-[9px] text-inter-beige uppercase font-black tracking-[0.3em] mt-1">Años de Trayectoria</p>
                </div>
            </div>
        </div>
    </section>

    <!-- LÓGICA VANILLA JS -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // --- 1. CARRUSEL HERO ---
            const items = document.querySelectorAll('.carousel-item');
            const dots = document.querySelectorAll('.dot');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            let currentSlide = 0;
            let autoPlayInterval;

            const updateCarousel = (index) => {
                items.forEach(item => { item.style.opacity = '0'; item.style.zIndex = '0'; });
                dots.forEach(dot => { dot.classList.remove('bg-white', 'w-10'); dot.classList.add('bg-white/40', 'w-3'); });

                items[index].style.opacity = '1';
                items[index].style.zIndex = '10';
                dots[index].classList.remove('bg-white/40', 'w-3');
                dots[index].classList.add('bg-white', 'w-10');
                currentSlide = index;
            };

            const nextSlide = () => { let next = (currentSlide + 1) % items.length; updateCarousel(next); };
            const prevSlide = () => { let prev = (currentSlide - 1 + items.length) % items.length; updateCarousel(prev); };

            if(nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); resetInterval(); });
            if(prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); resetInterval(); });

            dots.forEach(dot => {
                dot.addEventListener('click', (e) => {
                    const index = parseInt(e.target.getAttribute('data-index'));
                    updateCarousel(index);
                    resetInterval();
                });
            });

            const startInterval = () => { autoPlayInterval = setInterval(nextSlide, 7000); };
            const resetInterval = () => { clearInterval(autoPlayInterval); startInterval(); };
            startInterval();

            // --- 2. LÓGICA DE REPRODUCCIÓN DE VIDEO (Con Sonido) ---
            const container = document.getElementById('mainVideoContainer');
            const video = document.getElementById('homeMainVideo');
            const overlay = document.getElementById('mainVideoOverlay');
            const labels = document.getElementById('mainVideoLabels');

            if (container && video) {
                container.addEventListener('click', () => {
                    if (video.paused) {
                        video.play();
                        overlay.classList.add('opacity-0', 'pointer-events-none');
                        labels.classList.add('opacity-0');
                    } else {
                        video.pause();
                        overlay.classList.remove('opacity-0', 'pointer-events-none');
                        labels.classList.remove('opacity-0');
                    }
                });
            }

            // --- 3. CONTADORES MÉTRICAS ---
            const counters = document.querySelectorAll('.counter');
            const metricsSection = document.getElementById('metrics-section');

            const startCounters = () => {
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    let current = 0;
                    const speed = 100;
                    const increment = target / speed;

                    const update = () => {
                        if (current < target) {
                            current += increment;
                            counter.innerText = Math.ceil(current);
                            requestAnimationFrame(update);
                        } else {
                            counter.innerText = target + (target >= 100 ? '+' : '');
                        }
                    };
                    update();
                });
            };

            if (metricsSection) {
                const observer = new IntersectionObserver((entries) => {
                    if(entries[0].isIntersecting){
                        startCounters();
                        observer.unobserve(entries[0].target);
                    }
                }, { threshold: 0.3 });
                observer.observe(metricsSection);
            }
        });
    </script>
@endsection