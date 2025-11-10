@if ($paginator->hasPages())
    <div class="flex justify-between items-center gap-4">
        {{-- Data Information Text --}}
        <div class="text-xs text-base-content/70">
            @php
                $from = ($paginator->currentPage() - 1) * $paginator->perPage() + 1;
                $to = min($paginator->currentPage() * $paginator->perPage(), $paginator->total());
            @endphp
            Menampilkan {{ $from }} - {{ $to }} dari {{ $paginator->total() }}
        </div>

        {{-- Navigation Buttons --}}
        <div>
            <div class="join">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <button class="join-item btn btn-disabled">«</button>
                @else
                    <button class="join-item btn" wire:click="previousPage" wire:loading.attr="disabled">«</button>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <button class="join-item btn btn-disabled">{{ $element }}</button>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <button class="join-item btn btn-active">{{ $page }}</button>
                            @else
                                <button class="join-item btn" wire:click="gotoPage({{ $page }})"
                                    wire:loading.attr="disabled">{{ $page }}</button>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <button class="join-item btn" wire:click="nextPage" wire:loading.attr="disabled">»</button>
                @else
                    <button class="join-item btn btn-disabled">»</button>
                @endif
            </div>

            {{-- Loading State --}}
            <div wire:loading class="flex justify-center mt-2 rounded-l-xl">
                <span class="loading loading-spinner loading-sm"></span>
                <span class="ml-2 text-sm">Loading...</span>
            </div>
        </div>
    </div>
@else
    {{-- Show data info even when there's only one page --}}
    <div class="flex justify-start">
        <div class="text-sm text-base-content/70">
            Menampilkan {{ $paginator->total() }} data
        </div>
    </div>
@endif
