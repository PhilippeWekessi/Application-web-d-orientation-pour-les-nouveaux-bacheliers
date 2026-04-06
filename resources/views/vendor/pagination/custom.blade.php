@if ($paginator->hasPages())
    @if ($paginator->onFirstPage())
        <span class="pagination-disabled">«</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}">«</a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span>{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <a href="{{ $url }}" class="active">{{ $page }}</a>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}">»</a>
    @else
        <span class="pagination-disabled">»</span>
    @endif
@endif