@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-6 py-3 text-[10px] font-black uppercase tracking-widest text-gray-300 bg-white border border-gray-100 cursor-default leading-5 rounded-2xl shadow-sm">
                    Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-6 py-3 text-[10px] font-black uppercase tracking-widest text-gray-700 bg-white border border-gray-200 leading-5 rounded-2xl hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 shadow-sm">
                    Anterior
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-6 py-3 ml-3 text-[10px] font-black uppercase tracking-widest text-gray-700 bg-white border border-gray-200 leading-5 rounded-2xl hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 shadow-sm">
                    Siguiente
                </a>
            @else
                <span class="relative inline-flex items-center px-6 py-3 ml-3 text-[10px] font-black uppercase tracking-widest text-gray-300 bg-white border border-gray-100 cursor-default leading-5 rounded-2xl shadow-sm">
                    Siguiente
                </span>
            @endif
        </div>

        {{-- Vista Desktop: Números y texto de resultados --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-[10px] md:text-xs text-gray-400 font-bold uppercase tracking-widest">
                    Mostrando
                    <span class="font-black text-gray-800">{{ $paginator->firstItem() }}</span>
                    a
                    <span class="font-black text-gray-800">{{ $paginator->lastItem() }}</span>
                    de
                    <span class="font-black text-gray-800">{{ $paginator->total() }}</span>
                    resultados
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-xl overflow-hidden border border-gray-200">
                    {{-- Botón Anterior --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Anterior">
                            <span class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-300 cursor-default leading-5" aria-hidden="true">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-500 hover:text-gray-700 focus:z-10 focus:outline-none focus:ring ring-gray-300 active:bg-gray-100 transition ease-in-out duration-150" aria-label="Anterior">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </a>
                    @endif

                    {{-- Números de Página --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span aria-disabled="true" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 cursor-default leading-5">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 bg-[#333] text-sm font-bold text-white cursor-default leading-5">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring ring-gray-300 active:bg-gray-100 transition ease-in-out duration-150" aria-label="Ir a la página {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Botón Siguiente --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-500 hover:text-gray-700 focus:z-10 focus:outline-none focus:ring ring-gray-300 active:bg-gray-100 transition ease-in-out duration-150" aria-label="Siguiente">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Siguiente">
                            <span class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-300 cursor-default leading-5" aria-hidden="true">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif