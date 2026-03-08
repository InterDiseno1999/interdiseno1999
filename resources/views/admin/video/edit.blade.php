@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-2 sm:px-4">
    <div class="text-center mb-8 md:mb-10">
        <h1 class="text-3xl md:text-4xl font-bold border-b-2 border-black inline-block pb-2 px-8 uppercase tracking-tighter text-gray-800">
            Gestión Multimedia
        </h1>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-500 text-white rounded-2xl font-bold text-center shadow-lg animate-fade-in">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-8 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-2xl text-xs font-bold uppercase tracking-widest">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Card Principal -->
    <div class="bg-[#C0B7B1]/40 rounded-3xl md:rounded-[2.5rem] p-6 md:p-12 border border-gray-100 shadow-sm">
        <form action="{{ route('admin.video.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf

            <!-- Visualización del Video Actual -->
            <div class="space-y-4">
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Video Actual en el Home</label>
                
                <div class="relative w-full aspect-video bg-[#333333] rounded-[2rem] overflow-hidden shadow-xl border-4 border-white/20">
                    @if(File::exists(public_path('assets/video/home_background_video.mp4')))
                        <video class="w-full h-full object-cover" autoplay muted loop playsinline key="{{ time() }}">
                            <source src="{{ asset('assets/video/home_background_video.mp4') }}?v={{ time() }}" type="video/mp4">
                            Tu navegador no soporta videos.
                        </video>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-white/20">
                            <i class="fas fa-video-slash text-5xl mb-4"></i>
                            <p class="text-[10px] font-bold uppercase tracking-widest">No hay video cargado</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sección de Carga -->
            <div class="space-y-4">
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Reemplazar Video de Fondo *</label>
                
                <div x-data="{ fileName: 'Ningún archivo seleccionado' }" class="flex flex-col sm:flex-row items-center bg-white rounded-2xl overflow-hidden shadow-inner border border-gray-100 group">
                    <label class="w-full sm:w-auto bg-gray-200 px-8 py-3.5 cursor-pointer hover:bg-gray-300 transition-colors text-[10px] font-bold text-gray-700 uppercase tracking-widest text-center">
                        Seleccionar Video
                        <input type="file" name="video_file" class="hidden" @change="fileName = $event.target.files[0].name">
                    </label>
                    <span class="px-6 py-3 sm:py-0 text-gray-400 text-[11px] italic truncate w-full text-center sm:text-left" x-text="fileName"></span>
                </div>
                <div class="flex flex-col items-left gap-2 pl-2">
                    
                    <p class="text-[9px] text-gray-400 uppercase font-black tracking-widest"><i class="fas fa-info-circle text-gray-400 text-[10px] mr-1 "></i>Recomendado: Video horizontal (1920x1080).</p>
                    <p class="text-[9px] text-gray-400 uppercase font-black tracking-widest"><i class="fas fa-info-circle text-gray-400 text-[10px] mr-1 "></i>Tamaño máximo de video: 500MB</p>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-black/5">
                <a href="{{ route('admin.index') }}" 
                    class="order-2 sm:order-1 px-10 py-3 bg-white border border-gray-200 rounded-xl font-bold text-[10px] uppercase text-gray-400 hover:text-black transition text-center">
                    Volver al Panel
                </a>
                <button type="submit" 
                    class="order-1 sm:order-2 px-10 py-3 bg-[#333333] text-white rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-black transition shadow-lg">
                    Actualizar Multimedia
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .animate-fade-in { animation: fadeIn 0.5s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection