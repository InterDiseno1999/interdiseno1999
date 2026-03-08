<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | InterDiseñoSRL</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo_interdiseno_nav.png')}}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f4f2f1; 
        }
        .bg-admin-beige { background-color: #c1b5b2; }
        .bg-admin-dark { background-color: #333333; }
        
        /* Animación de Hamburguesa */
        .hamb-line {
            display: block; width: 24px; height: 2px;
            background-color: #333; transition: all 0.3s ease-in-out; border-radius: 2px;
        }
        .hamb-line.top-x { transform: translateY(7px) rotate(45deg); }
        .hamb-line.mid-x { opacity: 0; transform: translateX(-10px); }
        .hamb-line.bot-x { transform: translateY(-7px) rotate(-45deg); }

        #adminDropdownMenu.hidden {
            display: none;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <header class="bg-admin-beige py-3 px-8 shadow-sm sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center relative">
            <!-- Logo -->
            <a href="{{ route('admin.index') }}" class="flex items-center space-x-2">
                <img src="{{ asset('img/logo_interdiseno_admin.png') }}" alt="InterDiseño" class="h-10 md:h-16 w-auto object-contain mt-5">
            </a>
            
            <!-- Menú Desplegable -->
            <div class="relative">
                <button id="menuToggleButton" class="focus:outline-none p-3 hover:bg-black/5 rounded-xl transition-all flex flex-col justify-center items-center gap-[5px] w-12 h-12">
                    <span id="hambLineTop" class="hamb-line"></span>
                    <span id="hambLineMid" class="hamb-line"></span>
                    <span id="hambLineBot" class="hamb-line"></span>
                </button>

                <div id="adminDropdownMenu" 
                     class="hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50 py-2">
                    
                    <a href="{{ route('admin.index') }}" class="px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-[#C0B7B1]/20 flex items-center space-x-3 transition">
                        <i class="fas fa-home opacity-40 w-5 text-center"></i> <span>Inicio</span>
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}" class="px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-[#C0B7B1]/20 flex items-center space-x-3 transition">
                        <i class="fas fa-scroll opacity-40 w-5 text-center"></i> <span>Productos</span>
                    </a>

                    <a href="{{ route('admin.variants.index') }}" class="px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-[#C0B7B1]/20 flex items-center space-x-3 transition">
                        <i class="fas fa-palette opacity-40 w-5 text-center"></i> <span>Variantes</span>
                    </a>

                    <a href="{{ route('admin.compositions.index') }}" class="px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-[#C0B7B1]/20 flex items-center space-x-3 transition">
                        <i class="fas fa-layer-group opacity-40 w-5 text-center"></i> <span>Composiciones</span>
                    </a>

                    <a href="{{ route('admin.video.edit') }}" class="px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-[#C0B7B1]/20 flex items-center space-x-3 transition">
                        <i class="fas fa-play opacity-40 w-5 text-center"></i> <span>Multimedia (Video)</span>
                    </a>

                    <div class="border-t border-gray-100 my-2"></div>

                    <a href="{{ route('admin.logout') }}" class="px-6 py-3 text-sm font-bold text-red-500 hover:bg-red-50 flex items-center space-x-3 transition">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i> <span>Cerrar Sesión</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido Principal: flex-grow asegura que ocupe el espacio restante -->
    <main class="flex-grow container mx-auto px-4 py-12">
        @yield('content')
    </main>

    <!-- Footer Admin: Siempre al fondo -->
    <footer class="py-8 text-center bg-admin-beige border-t border-gray-100">
        <p class="text-black text-[10px] uppercase tracking-widest font-bold">© InterDiseñoSL 1999 - Todos los derechos reservados</p>
    </footer>

    <!-- Lógica de Navegación -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('menuToggleButton');
            const menu = document.getElementById('adminDropdownMenu');
            const top = document.getElementById('hambLineTop');
            const mid = document.getElementById('hambLineMid');
            const bot = document.getElementById('hambLineBot');

            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('hidden');
                top.classList.toggle('top-x');
                mid.classList.toggle('mid-x');
                bot.classList.toggle('bot-x');
            });

            document.addEventListener('click', function(e) {
                if (!menu.contains(e.target) && e.target !== btn) {
                    menu.classList.add('hidden');
                    top.classList.remove('top-x');
                    mid.classList.remove('mid-x');
                    bot.classList.remove('bot-x');
                }
            });
        });
    </script>

</body>
</html>