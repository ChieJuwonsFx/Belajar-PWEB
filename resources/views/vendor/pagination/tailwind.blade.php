@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="mt-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            {{-- Info text --}}
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Showing 
                <span class="font-medium">{{ $paginator->firstItem() ?? 0 }}</span>
                to 
                <span class="font-medium">{{ $paginator->lastItem() ?? 0 }}</span>
                of 
                <span class="font-medium">{{ $paginator->total() }}</span>
                results
            </div>

            {{-- Pagination links --}}
            <div class="flex items-center gap-1">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="px-3 py-1 rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" 
                       class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors"
                       aria-label="Previous">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="px-3 py-1 text-gray-400">...</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-3 py-1 rounded bg-primary text-white font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" 
                                   class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors"
                                   aria-label="Go to page {{ $page }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" 
                       class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors"
                       aria-label="Next">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @else
                    <span class="px-3 py-1 rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif
            </div>
        </div>

        {{-- Mobile view --}}
        <div class="flex justify-between sm:hidden mt-4">
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="px-4 py-2 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                    Previous
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="px-4 py-2 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                    Next
                </a>
            @else
                <span class="px-4 py-2 rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>
    </nav>
@endif