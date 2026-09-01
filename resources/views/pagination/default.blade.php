<div class="pagination-container">
    <p class="pagination-info">
        Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries
    </p>
    
    <div class="pagination-links">
        {{-- Previous page button --}}
        @if ($paginator->onFirstPage())
            <span class="disabled prev-next">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="prev-next">Previous</a>
        @endif

        {{-- Show page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next page button --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="prev-next">Next</a>
        @else
            <span class="disabled prev-next">Next</span>
        @endif
    </div>
</div>