@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination  flex-wrap float-right mb-0">

            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i
                            class="fas fa-angle-left"></i></a></li>
            @else
                <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link"><i
                            class="fas fa-angle-left"></i></a></li>
            @endif
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span>{{ $element }}</span></li>
                @endif
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active my-active"><a href="#"
                                    class="page-link">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}"
                                    class="page-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link"><i
                            class="fas fa-angle-right"></i></a></li>
            @else
                <li class="page-item disabled"><a href="#" class="page-link"><i
                            class="fas fa-angle-right"></i></a></li>
            @endif
        </ul>
    </nav>
@endif
