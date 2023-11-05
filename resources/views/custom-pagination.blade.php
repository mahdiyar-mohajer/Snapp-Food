@if ($paginator->hasPages())
    <ul class="flex justify-center list-reset space-x-2 mt-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="w-8 h-8 flex items-center justify-center bg-gray-300 rounded-full"><span>&laquo;</span></li>
        @else
            <li class="w-8 h-8 flex items-center justify-center bg-blue-500 text-white rounded-full hover:bg-blue-700">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="w-8 h-8 flex items-center justify-center bg-gray-300 rounded-full"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="w-8 h-8 flex items-center justify-center bg-blue-500 text-white rounded-full"><span>{{ $page }}</span></li>
                    @else
                        <li class="w-8 h-8 flex items-center justify-center bg-gray-300 rounded-full hover:bg-blue-500">
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="w-8 h-8 flex items-center justify-center bg-blue-500 text-white rounded-full hover:bg-blue-700">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
            </li>
        @else
            <li class="w-8 h-8 flex items-center justify-center bg-gray-300 rounded-full"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
