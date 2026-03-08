@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
    <div class="container mx-auto px-4 py-12 md:py-20">
        <!-- Título de la Sección Refinado -->
        <div class="text-center mb-12 md:mb-20">
            <h1 class="text-2xl md:text-4xl font-bold border-b-2 border-black inline-block pb-2 px-8 uppercase tracking-tighter text-gray-800">
                Contacto
            </h1>
        </div>

        <div class="max-w-xl mx-auto">
            <!-- Mensajes de Estado -->
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-500 text-white rounded-2xl font-bold text-center shadow-lg animate-fade-in text-xs md:text-sm">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-8 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-2xl text-xs font-bold uppercase tracking-widest">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario con Estética de Burbuja -->
            <div class="bg-inter-beige border border-gray-100 p-8 md:p-12 rounded-3xl md:rounded-[2.5rem] shadow-sm">
                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tighter text-gray-800">Envíanos una consulta</h2>
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-500 mt-2">Responderemos a la brevedad</p>
                </div>
                
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Nombre Completo *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                            placeholder="Ingresá tu nombre" 
                            class="w-full p-4 rounded-2xl border-none focus:ring-2 focus:ring-inter-dark outline-none bg-white shadow-inner transition-all text-sm">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                            placeholder="Ingresá tu email" 
                            class="w-full p-4 rounded-2xl border-none focus:ring-2 focus:ring-inter-dark outline-none bg-white shadow-inner transition-all text-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Tu Consulta *</label>
                        <textarea name="message" rows="4" required 
                            placeholder="¿En qué podemos ayudarte?" 
                            class="w-full p-4 rounded-2xl border-none focus:ring-2 focus:ring-inter-dark outline-none bg-white shadow-inner transition-all resize-none text-sm">{{ old('message') }}</textarea>
                    </div>

                    <div class="text-center pt-4">
                        <button type="submit" class="w-full sm:w-auto bg-inter-dark text-white px-12 py-4 rounded-2xl font-bold text-xs uppercase tracking-[0.2em] hover:bg-black hover:scale-105 transition-all shadow-lg">
                            Enviar Mensaje
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-24 md:mt-32 text-center">
            <h2 class="text-2xl md:text-3xl font-bold border-b-2 border-gray-100 inline-block pb-3 mb-16 tracking-tighter uppercase">Nuestras Redes</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 max-w-6xl mx-auto">
                <!-- Instagram -->
                <a href="https://www.instagram.com/interdisenosrl" target="_blank" class="group bg-white p-6 rounded-3xl border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="w-16 h-16 bg-inter-beige/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-inter-dark transition-colors overflow-hidden">
                        <img src="{{ asset('img/icons/icono_instagram_contacto.png') }}" alt="Instagram" class="w-16 h-16 object-contain group-hover:scale-110 transition-transform">
                    </div>
                    <span class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Instagram</span>
                    <span class="text-xs font-bold text-gray-800">@interdiseñosrl</span>
                </a>

                <!-- Email (Nuevo diseño para el mail que pediste) -->
                <a href="mailto:info.interdiseno1999@gmail.com" class="group bg-white p-6 rounded-3xl border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="w-16 h-16 bg-inter-beige/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-inter-dark transition-colors overflow-hidden">
                        <img src="{{ asset('img/icons/icono_mail_contacto.png') }}" alt="Instagram" class="w-16 h-16 object-contain group-hover:scale-110 transition-transform">
                    </div>
                    <span class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Email</span>
                    <span class="text-[10px] md:text-xs font-bold text-gray-800 break-all">info.interdiseno1999@gmail.com</span>
                </a>
                
                <!-- Facebook -->
                <a href="https://www.facebook.com/profile.php?id=100009917525180" target="_blank" class="group bg-white p-6 rounded-3xl border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="w-16 h-16 bg-inter-beige/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-inter-dark transition-colors overflow-hidden">
                        <img src="{{ asset('img/icons/icono_facebook_contacto.png') }}" alt="Facebook" class="w-16 h-16 object-contain group-hover:scale-110 transition-transform">
                    </div>
                    <span class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Facebook</span>
                    <span class="text-xs font-bold text-gray-800">Inter Diseño SRL</span>
                </a>

                <!-- LinkedIn -->
                <a href="https://es.linkedin.com/company/interdiseño" target="_blank" class="group bg-white p-6 rounded-3xl border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="w-16 h-16 bg-inter-beige/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-inter-dark transition-colors overflow-hidden">
                        <img src="{{ asset('img/icons/icono_linkedin_contacto.png') }}" alt="Linkedin" class="w-16 h-16 object-contain group-hover:scale-110 transition-transform">
                    </div>
                    <span class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">LinkedIn</span>
                    <span class="text-xs font-bold text-gray-800">interdiseno</span>
                </a>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
@endsection