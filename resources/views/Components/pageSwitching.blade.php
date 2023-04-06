<link rel="stylesheet" href="{{ asset('css/PageSwitching.css') }}" />

<div class="page-switching">
    @php
        $currentDir = dirname(url()->current());
    @endphp

    @if ($currentPage > 0)
        <button type="button" class="button-blue"
            onclick="window.location='{{ $currentDir }}/{{ $currentPage - 1 }}'">&#8249
        </button>
    @endif
    &nbsp {{ $pageStart }}-{{ $pageEnd }}&nbsp

    <button type="button" class="button-blue"
        onclick="window.location='{{ $currentDir }}/{{ $currentPage + 1 }}'">&#8250
    </button>
</div>
