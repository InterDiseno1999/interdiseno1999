@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-2 sm:px-4">
    <!-- Título Principal -->
    <div class="text-center mb-8 md:mb-12">
        <h1 class="text-2xl md:text-4xl font-bold border-b-2 border-black inline-block pb-2 px-6 md:px-12 uppercase tracking-tighter">
            Gestión de Composiciones
        </h1>
    </div>

    <!-- Mensajes de Éxito -->
    @if(session('success'))
        <div class="mb-8 p-4 bg-green-500 text-white rounded-2xl font-bold text-center shadow-lg animate-fade-in">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Cabecera de acciones -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4 px-2">
        <a href="{{ route('admin.compositions.create') }}" class="w-full sm:w-auto bg-[#333333] text-white px-8 py-3 rounded-xl font-bold hover:bg-black transition text-xs md:text-sm shadow-md flex items-center justify-center gap-2 uppercase tracking-widest">
            <i class="fas fa-plus text-[10px]"></i>
            <span>Nueva Composición</span>
        </a>
        <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] bg-white px-4 py-2 rounded-full shadow-sm border border-gray-50">
            Total: {{ $compositions->count() }}
        </p>
    </div>

    <!-- Contenedor de Lista -->
    <div class="bg-[#C0B7B1]/40 rounded-3xl md:rounded-3xl overflow-hidden shadow-sm border border-gray-100">
        <table class="hidden md:table w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#333333] text-white uppercase text-[10px] tracking-widest font-bold">
                    <th class="px-10 py-4">Nombre de Fibra</th>
                    <th class="px-10 py-4 text-center">Identificador</th>
                    <th class="px-10 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse($compositions as $composition)
                    <tr class="hover:bg-white/30 transition-colors group">
                        <td class="px-10 py-6 text-lg font-bold text-gray-800">{{ $composition->name }}</td>
                        <td class="px-10 py-6 text-center font-bold text-lg text-gray-500/50">#{{ $composition->id }}</td>
                        <td class="px-10 py-6 text-right space-x-2">
                            <a href="{{ route('admin.compositions.edit', $composition->id) }}" class="inline-block bg-[#C0B7B1] p-3 rounded-xl text-gray-700 hover:bg-white transition shadow-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" 
                                onclick="confirmDeleteComposition('{{ route('admin.compositions.destroy', $composition->id) }}')"
                                class="bg-[#333333] p-3 rounded-xl text-white hover:bg-red-600 transition shadow-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-20 text-center italic text-gray-400">No hay registros</td></tr>
                @endforelse
            </tbody>
        </table>

        <!-- Vista Mobile: Card Layout -->
        <div class="md:hidden divide-y divide-black/10">
            @forelse($compositions as $composition)
                <div class="p-6 flex flex-col gap-4 hover:bg-white/20 transition-colors">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Nombre</span>
                            <p class="text-xl font-bold text-gray-800 leading-tight">{{ $composition->name }}</p>
                        </div>
                        <span class="text-sm font-bold text-gray-400">#{{ $composition->id }}</span>
                    </div>
                    
                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('admin.compositions.edit', $composition->id) }}" class="flex-1 bg-[#C0B7B1] py-3 rounded-2xl text-gray-700 font-bold text-center text-sm shadow-sm flex items-center justify-center gap-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" 
                            onclick="confirmDeleteComposition('{{ route('admin.compositions.destroy', $composition->id) }}')"
                            class="flex-1 bg-[#333333] py-3 rounded-2xl text-white font-bold text-center text-sm shadow-sm flex items-center justify-center gap-2">
                            <i class="fas fa-trash"></i> Borrar
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-400 italic font-bold">No hay fibras registradas.</div>
            @endforelse
        </div>
    </div>

    <!-- MODAL DE CONFIRMACIÓN -->
    <div id="deleteCompositionModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="relative bg-white rounded-3xl md:rounded-[2.5rem] shadow-2xl max-w-sm w-full p-8 md:p-10 text-center animate-fade-in">
            <div class="w-16 h-16 md:w-20 md:h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2 tracking-tighter">¿Eliminar fibra?</h3>
            <p class="text-gray-500 text-xs md:text-sm mb-8 leading-relaxed">Esta acción es permanente y afectará a los productos vinculados.</p>
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button" onclick="closeDeleteModal()" class="w-full py-3 bg-gray-100 text-gray-600 font-bold rounded-2xl hover:bg-gray-200 transition order-2 sm:order-1 text-sm">Cancelar</button>
                <form id="deleteCompositionForm" method="POST" class="w-full order-1 sm:order-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-3 bg-[#333333] text-white font-bold rounded-2xl hover:bg-red-600 transition text-sm shadow-lg">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('deleteCompositionModal');
    const form = document.getElementById('deleteCompositionForm');

    function confirmDeleteComposition(url) {
        form.action = url;
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