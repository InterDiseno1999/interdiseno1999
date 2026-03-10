@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-2 sm:px-4">
    <div class="text-center mb-10">
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

    <div class="grid grid-cols-1 gap-8">
        <!-- Card 1: Video Actual (Detección MOV/MP4 y Sonido) -->
        <div class="bg-white rounded-3xl md:rounded-[2.5rem] p-6 md:p-10 border border-gray-100 shadow-sm">
            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-6 ml-2">Video Actual en el Home</label>
            
            <div class="relative w-full aspect-video bg-[#333333] rounded-[2rem] overflow-hidden shadow-xl border-4 border-gray-50 cursor-pointer group" id="adminVideoContainer">
                @php
                    $videoDirectory = 'assets/video';
                    $baseName = 'home_background_video';
                    $allFiles = \Storage::disk('supabase')->files($videoDirectory);
                    // Buscamos el archivo que coincida con el nombre base en la nube
                    $currentVideoPath = collect($allFiles)->first(fn($f) => str_contains($f, $baseName));
                    $isVideoMov = $currentVideoPath ? (Str::afterLast($currentVideoPath, '.') === 'mov') : false;
                @endphp

                @if($currentVideoPath)
                    {{-- Eliminamos 'muted' para permitir audio en la previsualización --}}
                    <video id="adminPreviewVideo" class="w-full h-full object-cover" loop playsinline>
                        <source src="{{ \Storage::disk('supabase')->url($currentVideoPath) }}?v={{ time() }}" 
                                type="video/{{ $isVideoMov ? 'quicktime' : 'mp4' }}">
                        Tu navegador no soporta videos.
                    </video>
                    
                    <div id="adminVideoOverlay" class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center z-10 transition-all duration-500">
                        <div class="w-16 h-16 border-2 border-white rounded-full flex items-center justify-center bg-white/10 backdrop-blur-sm group-hover:scale-110 transition-transform">
                            <i id="adminPlayIcon" class="fas fa-volume-up text-white text-2xl"></i>
                        </div>
                        <p class="mt-4 text-[9px] font-black text-white/60 uppercase tracking-widest text-center px-4">Clic para probar imagen y sonido</p>
                    </div>
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-white/20">
                        <i class="fas fa-video-slash text-5xl mb-4"></i>
                        <p class="text-[10px] font-bold uppercase tracking-widest">No hay video en la nube</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Card 2: Carga y Vista Previa del Nuevo Video -->
        <div class="bg-[#C0B7B1]/40 rounded-3xl md:rounded-[2.5rem] p-6 md:p-10 border border-gray-100 shadow-sm">
            <form action="{{ route('admin.video.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="space-y-6">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Subir Nuevo Video de Fondo *</label>
                    
                    <!-- Input Estilizado -->
                    <div class="flex flex-col sm:flex-row items-center bg-white rounded-2xl overflow-hidden shadow-inner border border-gray-100 group">
                        <label class="w-full sm:w-auto bg-gray-200 px-8 py-4 cursor-pointer hover:bg-gray-300 transition-colors text-[10px] font-bold text-gray-700 uppercase tracking-widest text-center">
                            <i class="fas fa-file-video mr-2"></i> Seleccionar Archivo
                            <input type="file" name="video_file" id="newVideoInput" class="hidden" accept=".mp4,.mov,video/mp4,video/quicktime">
                        </label>
                        <span id="fileNameLabel" class="px-6 py-4 sm:py-0 text-gray-400 text-[11px] italic truncate w-full text-center sm:text-left">Ningún video seleccionado</span>
                    </div>

                    <!-- SECCIÓN DE VISTA PREVIA (DINÁMICA) -->
                    <div id="newPreviewSection" class="hidden animate-fade-in space-y-4">
                        <div class="flex items-center gap-3 ml-2">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                            <p class="text-[10px] font-black uppercase tracking-widest text-blue-500">Vista previa del archivo (Soporta MOV y Sonido)</p>
                        </div>
                        
                        <div class="relative w-full aspect-video bg-black rounded-[2rem] overflow-hidden shadow-2xl border-4 border-blue-400/30">
                            {{-- Vista previa con controles habilitados --}}
                            <video id="newVideoPlayer" class="w-full h-full object-cover" controls>
                                <source src="" type="video/mp4">
                                Tu navegador no soporta la vista previa.
                            </video>
                        </div>
                        
                        <p class="text-[9px] text-gray-400 italic text-center">Revisá imagen y audio antes de procesar la subida.</p>
                    </div>

                    <div class="flex flex-col gap-2 pl-2">
                        <p class="text-[9px] text-gray-400 uppercase font-black tracking-widest"><i class="fas fa-info-circle mr-1"></i>Máximo 500MB. Formatos: MP4 o MOV (Mac/iPhone).</p>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-black/5">
                    <a href="{{ route('admin.index') }}" 
                        class="order-2 sm:order-1 px-10 py-4 bg-white border border-gray-200 rounded-2xl font-bold text-[10px] uppercase text-gray-400 hover:text-black transition text-center">
                        Volver al Panel
                    </a>
                    <button type="submit" id="uploadBtn" disabled
                        class="order-1 sm:order-2 px-10 py-4 bg-gray-300 text-white rounded-2xl font-bold text-[10px] uppercase tracking-widest transition-all shadow-lg cursor-not-allowed">
                        Procesar y Subir a la Nube
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- 1. LÓGICA VIDEO ACTUAL ---
        const currentContainer = document.getElementById('adminVideoContainer');
        const currentVideo = document.getElementById('adminPreviewVideo');
        const currentOverlay = document.getElementById('adminVideoOverlay');

        if (currentContainer && currentVideo) {
            currentContainer.addEventListener('click', () => {
                if (currentVideo.paused) {
                    currentVideo.play();
                    currentOverlay.classList.add('opacity-0', 'pointer-events-none');
                } else {
                    currentVideo.pause();
                    currentOverlay.classList.remove('opacity-0', 'pointer-events-none');
                }
            });
        }

        // --- 2. LÓGICA NUEVA VISTA PREVIA (DINÁMICA MOV/MP4) ---
        const videoInput = document.getElementById('newVideoInput');
        const previewSection = document.getElementById('newPreviewSection');
        const videoPlayer = document.getElementById('newVideoPlayer');
        const fileNameLabel = document.getElementById('fileNameLabel');
        const uploadBtn = document.getElementById('uploadBtn');

        videoInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                const isMov = file.name.toLowerCase().endsWith('.mov');
                
                // Actualizar Nombre
                fileNameLabel.innerText = file.name;
                fileNameLabel.classList.remove('text-gray-400', 'italic');
                fileNameLabel.classList.add('text-gray-800', 'font-bold');

                // Crear URL temporal para el video
                const fileURL = URL.createObjectURL(file);
                
                // Configurar el player de preview según el tipo
                videoPlayer.src = fileURL;
                videoPlayer.type = isMov ? 'video/quicktime' : 'video/mp4';
                
                // Mostrar sección y habilitar botón
                previewSection.classList.remove('hidden');
                uploadBtn.disabled = false;
                uploadBtn.classList.remove('bg-gray-300', 'cursor-not-allowed');
                uploadBtn.classList.add('bg-black', 'hover:scale-105');

                // Hacer scroll suave hacia la vista previa si es móvil
                if(window.innerWidth < 768) {
                    previewSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                previewSection.classList.add('hidden');
                uploadBtn.disabled = true;
                uploadBtn.classList.add('bg-gray-300', 'cursor-not-allowed');
            }
        });
    });
</script>

<style>
    .animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }
    @keyframes fadeIn { 
        from { opacity: 0; transform: translateY(15px); } 
        to { opacity: 1; transform: translateY(0); } 
    }

    #uploadBtn:not(:disabled):hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    }
</style>
@endsection