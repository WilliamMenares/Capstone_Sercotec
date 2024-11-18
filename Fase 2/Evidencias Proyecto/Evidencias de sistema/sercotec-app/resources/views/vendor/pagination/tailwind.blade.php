<nav role="navigation" aria-label="Pagination" class="flex justify-center mt-0"> <!-- Ajusté el margen superior a 0 -->
    <div class="flex items-center space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">&laquo;
                Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">&laquo;
                Anterior</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-2 text-sm text-gray-400 bg-gray-200">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="px-3 py-2 text-sm font-medium text-gray-600 bg-gray-300 rounded-md cursor-not-allowed">{{ $page }}</span>
                        <!-- Cambié a un gris más claro para el texto y el fondo -->
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-2 text-sm font-medium text-gray-600 bg-gray-200 hover:bg-gray-300 rounded-md">{{ $page }}</a>
                        <!-- Cambié a gris claro -->
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Siguiente
                &raquo;</a>
        @else
            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">Siguiente
                &raquo;</span>
        @endif
    </div>
</nav>
