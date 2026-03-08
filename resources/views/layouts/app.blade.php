<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InterDiseño - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo_interdiseno_nav.png')}}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-inter-dark { background-color: #3a3b3d; }
        .text-inter-dark { color: #3a3b3d; }
        .bg-inter-beige { background-color: #c1b5b2; }
        .nav-link { transition: all 0.3s; }
        .nav-link:hover { opacity: 0.7; }

        .fade-in-up {
            animation: fadeInUp 0.4s ease-out forwards;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Estilos para el Menú Hamburguesa */
        .hamb-line {
            display: block; width: 24px; height: 2px;
            background-color: white; transition: all 0.3s ease-in-out; border-radius: 2px;
        }
        .open .hamb-line:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .open .hamb-line:nth-child(2) { opacity: 0; transform: translateX(-10px); }
        .open .hamb-line:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* Menú Desplegable Compacto */
        #mobileMenu {
            max-height: 0;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            transform: translateY(-10px);
        }
        #mobileMenu.show {
            max-height: 500px; /* Suficiente para el contenido */
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen">

    <!-- Header / Nav -->
    <nav class="bg-inter-dark text-white sticky top-0 z-50 shadow-md">
        <div class="container mx-auto px-6 py-5 md:py-8 flex justify-between items-center relative">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('img/logo_interdiseno.png')}}" alt="InterDiseño Logo" class="h-8 md:h-12 w-auto object-contain">
            </a>
            
            <!-- Menú Desktop -->
            <div class="hidden md:flex items-center space-x-10">
                <div class="flex space-x-8 text-base">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400' }}">Inicio</a>
                    <a href="{{ route('products') }}" class="nav-link {{ request()->routeIs('products') ? 'text-white' : 'text-gray-400' }}">Productos</a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'text-white' : 'text-gray-400' }}">Contacto</a>
                </div>

                <!-- Iconos Sociales Desktop -->
                <div class="flex space-x-3 items-center">
                    <a href="https://www.instagram.com/interdisenosrl" target="_blank" class="rounded-full bg-inter-beige p-2 text-gray-600 hover:bg-white transition-all">
                        <img src="{{ asset('img/icons/icono_instagram.png')}}" alt="Instagram" class="w-5 h-5">
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=100009917525180" target="_blank" class="rounded-full bg-inter-beige p-2 text-gray-600 hover:bg-white transition-all">
                        <img src="{{ asset('img/icons/icono_facebook.png')}}" alt="Facebook" class="w-5 h-5">
                    </a>
                    <a href="https://es.linkedin.com/company/interdise%C3%B1o" target="_blank" class="rounded-full bg-inter-beige p-2 text-gray-600 hover:bg-white transition-all">
                        <img src="{{ asset('img/icons/icono_linkedin.png')}}" alt="Linkedin" class="w-5 h-5">
                    </a>
                </div>
            </div>

            <!-- Botón Hamburguesa (Solo Móvil) -->
            <button id="hambBtn" class="md:hidden p-2 flex flex-col gap-[5px] focus:outline-none">
                <span class="hamb-line"></span>
                <span class="hamb-line"></span>
                <span class="hamb-line"></span>
            </button>

            <!-- Menú Desplegable Móvil (Pequeño debajo del nav) -->
            <div id="mobileMenu" class="absolute top-full left-0 w-full bg-[#2a2b2d] border-t border-white/5 shadow-2xl md:hidden">
                <div class="flex flex-col p-6 space-y-4">
                    <a href="{{ route('home') }}" class="text-sm font-bold uppercase tracking-widest py-2 border-b border-white/5 {{ request()->routeIs('home') ? 'text-inter-beige' : 'text-white' }}" onclick="closeMobileMenu()">Inicio</a>
                    <a href="{{ route('products') }}" class="text-sm font-bold uppercase tracking-widest py-2 border-b border-white/5 {{ request()->routeIs('products') ? 'text-inter-beige' : 'text-white' }}" onclick="closeMobileMenu()">Productos</a>
                    <a href="{{ route('contact') }}" class="text-sm font-bold uppercase tracking-widest py-2 border-b border-white/5 {{ request()->routeIs('contact') ? 'text-inter-beige' : 'text-white' }}" onclick="closeMobileMenu()">Contacto</a>
                    
                    <!-- Redes Sociales en Menú Móvil -->
                    <div class="flex items-center space-x-4 pt-4">
                        <a href="https://www.instagram.com/interdisenosrl" target="_blank" class="w-10 h-10 rounded-full bg-inter-beige flex items-center justify-center shadow-md">
                            <img src="{{ asset('img/icons/icono_instagram.png')}}" alt="Instagram" class="w-5 h-5">
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=100009917525180" target="_blank" class="w-10 h-10 rounded-full bg-inter-beige flex items-center justify-center shadow-md">
                            <img src="{{ asset('img/icons/icono_facebook.png')}}" alt="Facebook" class="w-5 h-5">
                        </a>
                        <a href="https://es.linkedin.com/company/interdise%C3%B1o" target="_blank" class="w-10 h-10 rounded-full bg-inter-beige flex items-center justify-center shadow-md">
                            <img src="{{ asset('img/icons/icono_linkedin.png')}}" alt="Linkedin" class="w-5 h-5">
                        </a>
                    </div>
                    <p class="text-[9px] text-white/20 uppercase font-black tracking-[0.2em] pt-4">InterDiseño SRL | Est. 1999</p>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- BOTONES FLOTANTES -->
    <div class="fixed bottom-8 right-8 z-[40] flex flex-col gap-4">
        <button id="btnScrollTop" 
                onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                style="display: none;"
                class="w-14 h-14 bg-inter-beige rounded-full items-center justify-center shadow-2xl hover:scale-110 hover:bg-white transition-all duration-300 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="#3a3b3d" stroke-width="3.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
            </svg>
        </button>

        <a href="https://wa.me/5491131011299" 
           target="_blank" 
           class="w-14 h-14 bg-[#25D366] rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-all duration-300 overflow-hidden">
            <img src="{{ asset('img/icons/icono_whatsapp.png') }}" alt="WhatsApp" class="w-8 h-8">
        </a>
    </div>

    <!-- Footer -->
    <footer class="bg-inter-dark text-white py-12 border-t border-white/5 mt-10">
        <div class="container mx-auto px-4 text-center">
            <p class="text-xs opacity-50 mb-6 font-light">© InterDiseño 1999 - Todos los derechos reservados</p>
            <div class="flex justify-center space-x-12 text-[10px] opacity-40">
                <a href="#" class="hover:opacity-100 transition">Términos y Condiciones</a>
                <a href="#" class="hover:opacity-100 transition">Política de Privacidad</a>
            </div>
        </div>
    </footer>

    <script>
        // Lógica del Menú Hamburguesa Desplegable
        const hambBtn = document.getElementById('hambBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        function toggleMobileMenu() {
            hambBtn.classList.toggle('open');
            mobileMenu.classList.toggle('show');
        }

        function closeMobileMenu() {
            hambBtn.classList.remove('open');
            mobileMenu.classList.remove('show');
        }

        hambBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleMobileMenu();
        });

        // Cerrar al hacer clic fuera del menú
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !hambBtn.contains(e.target)) {
                closeMobileMenu();
            }
        });

        // Lógica del botón Scroll Top
        window.onscroll = function() {
            const btn = document.getElementById('btnScrollTop');
            if (window.scrollY > 300) {
                btn.style.display = 'flex';
                if (!btn.classList.contains('fade-in-up')) {
                    btn.classList.add('fade-in-up');
                }
            } else {
                btn.style.display = 'none';
                btn.classList.remove('fade-in-up');
            }
        };
    </script>

</body>
</html>