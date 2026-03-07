@extends('layouts.admin')

@section('content')
<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

<div class="max-w-5xl mx-auto px-2 sm:px-4">
    
    <!-- Título Principal Refinado -->
    <div class="text-center mb-8 md:mb-10">
        <h1 class="text-2xl md:text-4xl font-bold border-b-2 border-black inline-block pb-2 px-8 uppercase tracking-tighter text-gray-800">
            Nuevo Producto
        </h1>
    </div>

    @if ($errors->any())
        <div class="mb-8 p-5 bg-red-50 border-l-4 border-red-500 rounded-r-2xl shadow-sm">
            <ul class="list-disc list-inside text-red-600 text-xs md:text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        
        <div class="bg-[#C0B7B1]/40 rounded-3xl md:rounded-[2.5rem] p-6 md:p-12 border border-gray-100 shadow-sm space-y-8">
            
            <!-- Nombre -->
            <div class="space-y-3">
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Nombre del Producto *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ingresá nombre del producto" 
                    class="w-full p-4 rounded-2xl border-none shadow-sm focus:ring-2 focus:ring-black outline-none text-base bg-white/80 transition-all">
            </div>

            <!-- Grilla Principal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10">
                <div class="space-y-3">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Descripción *</label>
                    <textarea name="description" required rows="8" placeholder="Ingresá descripción del producto..." 
                        class="w-full p-4 rounded-3xl border-none shadow-sm focus:ring-2 focus:ring-black outline-none text-base resize-none bg-white/80 transition-all">{{ old('description') }}</textarea>
                </div>

                <div class="space-y-6">
                    <!-- Disponibilidad -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Disponibilidad</label>
                        <div class="flex items-center gap-4 bg-white/90 p-4 rounded-2xl shadow-sm border border-gray-50">
                            <button type="button" id="stockToggleButton"
                                class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors duration-300 focus:outline-none shadow-inner bg-green-500">
                                <span id="stockToggleCircle" class="translate-x-6 inline-block h-5 w-5 transform rounded-full bg-white transition-transform duration-300 shadow-md"></span>
                            </button>
                            <span id="stockStatusText" class="font-bold text-xs md:text-sm uppercase tracking-tight text-green-600">Disponible</span>
                            <input type="hidden" name="stock" id="stockHiddenInput" value="1">
                        </div>
                    </div>

                    <!-- Ancho -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Ancho de la tela (mts) *</label>
                        <input type="text" name="width" id="productWidth" value="{{ old('width') }}" required placeholder="Ej: 1.40 (sin el mts.)" 
                            class="w-full p-4 rounded-2xl border-none shadow-sm focus:ring-2 focus:ring-black outline-none text-base bg-white/80">
                    </div>

                    <!-- Composición -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Composición *</label>
                        <div class="relative">
                            <select id="compositionSelect" class="w-full p-4 rounded-2xl border-none shadow-sm bg-white/80 outline-none focus:ring-2 focus:ring-black text-sm appearance-none cursor-pointer">
                                <option value="" disabled selected>Añadir composición...</option>
                                @foreach($compositions as $comp)
                                    <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-plus absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 text-xs"></i>
                        </div>
                        <div id="selectedCompositionsContainer" class="flex flex-wrap gap-2 mt-3 px-1"></div>
                    </div>
                </div>
            </div>

            <!-- Variantes y Diseño -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 pt-2">
                <div class="space-y-3">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Variantes de Color *</label>
                    <div class="relative">
                        <select id="variantSelect" class="w-full p-4 rounded-2xl border-none shadow-sm bg-white/80 text-sm outline-none appearance-none cursor-pointer">
                            <option value="">Seleccionar colores...</option>
                            @foreach($baseVariants as $v)
                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-palette absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 text-[10px]"></i>
                    </div>
                    <div id="selectedVariantsContainer" class="flex flex-wrap gap-2 mt-3 px-1"></div>
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">¿Posee Estampado? *</label>
                    <div class="relative">
                        <select name="has_design" id="hasDesignSelect" class="w-full p-4 rounded-2xl border-none shadow-sm bg-white/80 text-sm outline-none appearance-none cursor-pointer">
                            <option value="no">No</option>
                            <option value="si">Sí</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 text-[10px]"></i>
                    </div>
                </div>
            </div>

            <!-- Sección Diseños -->
            <div id="designVariantsSection" class="hidden grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-start-2 space-y-3">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-blue-400 ml-2">Asignar Diseños Específicos *</label>
                    <div class="relative">
                        <select id="designVariantSelect" class="w-full p-4 rounded-2xl border-none shadow-sm bg-blue-50/50 text-sm outline-none appearance-none cursor-pointer">
                            <option value="">Elegir diseño...</option>
                            @foreach($designVariants as $dv)
                                <option value="{{ $dv->id }}">{{ $dv->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-magic absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-blue-300 text-[10px]"></i>
                    </div>
                    <div id="selectedDesignVariantsContainer" class="flex flex-wrap gap-2 mt-3 px-1"></div>
                </div>
            </div>

            <!-- Imagen Principal -->
            <div class="space-y-4 pt-2">
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 ml-2">Imagen de Portada *</label>
                <div class="flex flex-col sm:flex-row items-center bg-white/80 rounded-2xl overflow-hidden shadow-sm border border-gray-100 group">
                    <label class="w-full sm:w-auto bg-gray-200 px-8 py-3 cursor-pointer hover:bg-gray-300 font-bold text-[10px] uppercase tracking-widest transition-colors text-center">
                        Elegir Foto
                        <input type="file" id="mainImageInput" class="hidden" accept="image/*">
                    </label>
                    <span id="mainImageName" class="px-6 py-3 sm:py-0 text-gray-400 text-[11px] italic truncate w-full text-center sm:text-left">Sin archivos seleccionados</span>
                    <input type="hidden" name="main_image_cropped" id="mainImageCropped">
                </div>
                <div id="mainImagePreviewContainer" class="hidden mt-6 text-center animate-fade-in">
                    <img id="mainImagePreview" src="" class="mx-auto h-40 md:h-52 rounded-[2rem] shadow-xl border-4 border-white object-cover">
                </div>
            </div>

            <div id="persistentFilesContainer" class="hidden"></div>

            <!-- Gestión de Variantes -->
            <div class="flex flex-col lg:flex-row items-center gap-6 pt-4">
                <button type="button" id="openModalButton" class="w-full lg:w-auto bg-[#866c62] text-white px-8 py-4 rounded-2xl font-bold uppercase tracking-widest shadow-xl hover:bg-[#333333] transition-all text-[10px]">
                    Gestionar fotos por variante
                </button>
                <div class="w-full lg:w-auto bg-white/60 px-8 py-4 rounded-2xl border-2 border-gray-100 font-black text-gray-400 uppercase tracking-[0.2em] text-[9px] shadow-inner text-center">
                    Asignadas: <span id="assignedCountText" class="text-black">0</span> / <span id="totalCountText">0</span>
                </div>
            </div>

            <!-- Botones Finales -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-8 border-t border-black/5">
                <a href="{{ route('admin.products.index') }}" class="order-2 sm:order-1 px-10 py-3 bg-white border-2 border-gray-200 rounded-2xl font-bold text-gray-400 text-xs uppercase hover:text-black text-center transition-all">Cancelar</a>
                <button type="submit" id="submitBtn" class="order-1 sm:order-2 px-10 py-3 bg-[#333] text-white rounded-2xl font-bold text-xs shadow-lg hover:bg-black transition-all flex items-center justify-center gap-3 uppercase tracking-widest">
                    Crear Producto
                </button>
            </div>
        </div>
    </form>

    <!-- MODAL VARIANTES -->
    <div id="variantsModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-3 md:p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-[#C0B7B1] rounded-3xl md:rounded-[3.5rem] shadow-2xl max-w-4xl w-full p-8 md:p-10 flex flex-col max-h-[90vh] animate-fade-in mx-2">
            <div class="flex justify-between items-center mb-6 px-2">
                <h2 class="text-lg md:text-xl font-bold tracking-tighter uppercase">Fotos de Variantes</h2>
                <button type="button" id="closeModalCross" class="text-2xl hover:text-white transition-colors">&times;</button>
            </div>
            <div id="modalContentContainer" class="flex-1 overflow-y-auto space-y-5 pr-2"></div>
            <div class="mt-8">
                <button type="button" id="closeModalButton" class="w-full bg-black text-white px-10 py-4 rounded-2xl font-bold uppercase shadow-lg text-[10px] tracking-widest">Confirmar e Cerrar</button>
            </div>
        </div>
    </div>

    <!-- MODAL DE RECORTE -->
    <div id="cropperModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-2 md:p-4 bg-black/90 backdrop-blur-md">
        <div class="bg-white rounded-3xl md:rounded-[2.5rem] shadow-2xl max-w-5xl w-full overflow-hidden flex flex-col animate-fade-in mx-2">
            <div class="p-5 bg-white border-b flex flex-col sm:flex-row justify-between items-center px-8 gap-3">
                <div class="text-center sm:text-left">
                    <h3 class="font-bold text-base md:text-lg uppercase tracking-tighter text-gray-800">Editor de Género</h3>
                </div>
                <span id="cropRatioText" class="text-[9px] font-black bg-inter-beige text-white px-4 py-1.5 rounded-full uppercase tracking-widest shadow-sm">...</span>
            </div>

            <div class="relative bg-gray-100 flex items-center justify-center overflow-hidden h-[300px] md:h-[450px]">
                <img id="imageToCrop" src="" class="max-w-full block">
            </div>

            <div class="p-6 bg-gray-50 border-t flex flex-col md:flex-row justify-between items-center gap-4">
                <button type="button" id="cancelCrop" class="order-3 md:order-1 w-full md:w-auto px-6 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-gray-400 hover:text-red-500 transition-colors text-[10px] uppercase tracking-widest">Descartar</button>
                
                <div class="order-1 md:order-2 flex gap-2 bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                    <button type="button" onclick="cropper.rotate(-90)" class="w-10 h-10 flex items-center justify-center bg-gray-50 rounded-lg hover:bg-admin-beige hover:text-white transition-all text-gray-400"><i class="fas fa-undo"></i></button>
                    <button type="button" onclick="cropper.zoom(0.1)" class="w-10 h-10 flex items-center justify-center bg-gray-50 rounded-lg hover:bg-admin-beige hover:text-white transition-all text-gray-400"><i class="fas fa-search-plus"></i></button>
                    <button type="button" onclick="cropper.zoom(-0.1)" class="w-10 h-10 flex items-center justify-center bg-gray-50 rounded-lg hover:bg-admin-beige hover:text-white transition-all text-gray-400"><i class="fas fa-search-minus"></i></button>
                    <button type="button" onclick="cropper.rotate(90)" class="w-10 h-10 flex items-center justify-center bg-gray-50 rounded-lg hover:bg-admin-beige hover:text-white transition-all text-gray-400"><i class="fas fa-redo"></i></button>
                </div>

                <button type="button" id="confirmCrop" class="order-2 md:order-3 w-full md:w-auto px-10 py-3 bg-black text-white rounded-xl font-bold uppercase tracking-widest shadow-xl hover:scale-105 transition-all text-[10px]">
                    Confirmar Corte
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cropper.js JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let state = {
        inStock: true,
        hasDesign: 'no',
        selectedCompositions: [],
        selectedVariants: [],
        selectedDesignVariants: []
    };

    let cropper = null;
    let currentTarget = null; 

    const persistentContainer = document.getElementById('persistentFilesContainer');
    const modalContent = document.getElementById('modalContentContainer');
    const imageToCrop = document.getElementById('imageToCrop');
    const cropperModal = document.getElementById('cropperModal');

    function openCropper(file, target) {
        currentTarget = target;
        const reader = new FileReader();
        reader.onload = (e) => {
            imageToCrop.src = e.target.result;
            cropperModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            const widthVal = document.getElementById('productWidth').value;
            let ratio = 1; 
            if(widthVal && parseFloat(widthVal) > 2) ratio = 16 / 9; 
            
            document.getElementById('cropRatioText').innerText = ratio === 1 ? "1:1" : "16:9";

            if (cropper) cropper.destroy();
            cropper = new Cropper(imageToCrop, {
                aspectRatio: ratio,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.8,
                background: false,
            });
        };
        reader.readAsDataURL(file);
    }

    document.getElementById('confirmCrop').onclick = function() {
        const canvas = cropper.getCroppedCanvas({ width: 1200, height: 1200, imageSmoothingQuality: 'high' });
        const croppedBase64 = canvas.toDataURL('image/jpeg', 0.85);

        if (currentTarget === 'main') {
            document.getElementById('mainImageCropped').value = croppedBase64;
            document.getElementById('mainImagePreview').src = croppedBase64;
            document.getElementById('mainImagePreviewContainer').style.display = 'block';
            document.getElementById('mainImageName').innerText = "Imagen principal lista";
        } else {
            const hiddenId = `cropped_file_${currentTarget.type}_${currentTarget.id}`;
            let hiddenInput = document.getElementById(hiddenId);
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.id = hiddenId;
                hiddenInput.name = currentTarget.type === 'base' ? `variant_images_cropped[${currentTarget.id}]` : `design_variant_images_cropped[${currentTarget.id}]`;
                persistentContainer.appendChild(hiddenInput);
            }
            hiddenInput.value = croppedBase64;
            const labelSpan = document.getElementById(`label_span_${currentTarget.type}_${currentTarget.id}`);
            if(labelSpan) labelSpan.innerText = "Corte listo";
        }
        closeCrop();
        updateCounts();
    };

    function closeCrop() {
        cropperModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        if (cropper) cropper.destroy();
    }

    document.getElementById('cancelCrop').onclick = closeCrop;
    document.getElementById('mainImageInput').onchange = function(e) {
        if (e.target.files[0]) openCropper(e.target.files[0], 'main');
    };

    function createPersistentInput(id, type) {
        const inputId = `file_input_${type}_${id}`;
        if (document.getElementById(inputId)) return;
        const input = document.createElement('input');
        input.type = 'file'; input.id = inputId; input.accept = "image/*"; input.className = "hidden";
        input.onchange = (e) => { if(e.target.files[0]) openCropper(e.target.files[0], {id, type}); };
        persistentContainer.appendChild(input);
    }

    function updateCounts() {
        let total = state.selectedVariants.length;
        if (state.hasDesign === 'si') total += state.selectedDesignVariants.length;
        let assigned = 0;
        persistentContainer.querySelectorAll('input[type="hidden"]').forEach(input => {
            if(input.value) assigned++;
        });
        document.getElementById('totalCountText').innerText = total;
        document.getElementById('assignedCountText').innerText = assigned;
    }

    function renderAllChips() {
        const containerC = document.getElementById('selectedCompositionsContainer'); containerC.innerHTML = '';
        state.selectedCompositions.forEach(c => {
            const chip = document.createElement('span');
            chip.className = "bg-[#333] text-white px-3 py-1.5 rounded-xl text-[9px] font-bold flex items-center gap-2";
            chip.innerHTML = `${c.name} <button type="button" onclick="removeItem('${c.id}', 'comp')">&times;</button><input type="hidden" name="compositions[]" value="${c.id}">`;
            containerC.appendChild(chip);
        });

        const containerV = document.getElementById('selectedVariantsContainer'); containerV.innerHTML = '';
        state.selectedVariants.forEach(v => {
            const chip = document.createElement('span');
            chip.className = "bg-white text-black border border-gray-100 px-3 py-1.5 rounded-xl text-[9px] font-bold flex items-center gap-2 shadow-sm";
            chip.innerHTML = `${v.name} <button type="button" onclick="removeItem('${v.id}', 'base')">&times;</button><input type="hidden" name="base_variants[]" value="${v.id}">`;
            containerV.appendChild(chip);
        });

        const containerDV = document.getElementById('selectedDesignVariantsContainer'); containerDV.innerHTML = '';
        state.selectedDesignVariants.forEach(dv => {
            const chip = document.createElement('span');
            chip.className = "bg-[#866c62] text-white px-3 py-1.5 rounded-xl text-[9px] font-bold flex items-center gap-2 shadow-sm";
            chip.innerHTML = `${dv.name} <button type="button" onclick="removeItem('${dv.id}', 'design')">&times;</button><input type="hidden" name="design_variants[]" value="${dv.id}">`;
            containerDV.appendChild(chip);
        });
        updateCounts();
    }

    window.removeItem = function(id, type) {
        if (type === 'comp') state.selectedCompositions = state.selectedCompositions.filter(c => c.id != id);
        else if (type === 'base') {
            state.selectedVariants = state.selectedVariants.filter(v => v.id != id);
            document.getElementById(`file_input_base_${id}`)?.remove();
        } else if (type === 'design') {
            state.selectedDesignVariants = state.selectedDesignVariants.filter(dv => dv.id != id);
            document.getElementById(`file_input_design_${id}`)?.remove();
        }
        renderAllChips();
    };

    function renderModal() {
        modalContent.innerHTML = '';
        const renderRow = (v, type) => {
            const inputId = `file_input_${type}_${v.id}`;
            createPersistentInput(v.id, type);
            const fileName = 'Sin archivo';
            const div = document.createElement('div');
            div.className = "bg-white/40 p-5 md:p-6 rounded-3xl border border-white/20";
            div.innerHTML = `
                <p class="font-bold mb-3 uppercase tracking-widest text-[9px] text-gray-500">${v.name}</p>
                <div class="flex flex-col sm:flex-row items-center bg-white rounded-2xl overflow-hidden shadow-inner border border-gray-50">
                    <button type="button" onclick="document.getElementById('${inputId}').click()" class="w-full sm:w-auto bg-gray-100 px-6 py-3 font-bold text-[9px] uppercase hover:bg-gray-200 transition">Cortar</button>
                    <span id="label_span_${type}_${v.id}" class="px-6 py-3 sm:py-0 text-gray-400 text-[10px] italic truncate w-full text-center sm:text-left">${fileName}</span>
                </div>
            `;
            modalContent.appendChild(div);
        };
        state.selectedVariants.forEach(v => renderRow(v, 'base'));
        if (state.hasDesign === 'si') state.selectedDesignVariants.forEach(dv => renderRow(dv, 'design'));
    }

    document.getElementById('stockToggleButton').onclick = function() {
        state.inStock = !state.inStock;
        this.className = `relative inline-flex h-7 w-12 items-center rounded-full transition-colors shadow-inner ${state.inStock ? 'bg-green-500' : 'bg-gray-300'}`;
        document.getElementById('stockToggleCircle').className = `${state.inStock ? 'translate-x-6' : 'translate-x-1'} inline-block h-5 w-5 transform rounded-full bg-white transition-transform`;
        document.getElementById('stockStatusText').innerText = state.inStock ? "Disponible" : "Sin Stock";
        document.getElementById('stockStatusText').className = `font-bold text-xs md:text-sm uppercase tracking-tight ${state.inStock ? 'text-green-600' : 'text-gray-400'}`;
        document.getElementById('stockHiddenInput').value = state.inStock ? "1" : "0";
    };

    document.getElementById('compositionSelect').onchange = (e) => {
        const id = e.target.value; const name = e.target.options[e.target.selectedIndex].text;
        if (id && !state.selectedCompositions.find(c => c.id == id)) { state.selectedCompositions.push({ id, name }); renderAllChips(); }
        e.target.value = '';
    };

    document.getElementById('variantSelect').onchange = (e) => {
        const id = e.target.value; const name = e.target.options[e.target.selectedIndex].text;
        if (id && !state.selectedVariants.find(v => v.id == id)) { state.selectedVariants.push({ id, name }); createPersistentInput(id, 'base'); renderAllChips(); }
        e.target.value = '';
    };

    document.getElementById('designVariantSelect').onchange = (e) => {
        const id = e.target.value; const name = e.target.options[e.target.selectedIndex].text;
        if (id && !state.selectedDesignVariants.find(dv => dv.id == id)) { state.selectedDesignVariants.push({ id, name }); createPersistentInput(id, 'design'); renderAllChips(); }
        e.target.value = '';
    };

    document.getElementById('hasDesignSelect').onchange = (e) => {
        state.hasDesign = e.target.value;
        document.getElementById('designVariantsSection').style.display = state.hasDesign === 'si' ? 'grid' : 'none';
        updateCounts();
    };

    document.getElementById('openModalButton').onclick = () => { renderModal(); document.getElementById('variantsModal').classList.remove('hidden'); };
    const hideModal = () => document.getElementById('variantsModal').classList.add('hidden');
    document.getElementById('closeModalButton').onclick = hideModal;
    document.getElementById('closeModalCross').onclick = hideModal;

    renderAllChips();
});
</script>

<style>
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .cropper-view-box, .cropper-face { border-radius: 0; }
    .cropper-line, .cropper-point { background-color: #C0B7B1; }
</style>
@endsection