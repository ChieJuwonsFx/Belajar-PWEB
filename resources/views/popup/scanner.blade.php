@props([
    'id'
])

<div id="{{ $id }}" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50">
    <div class="relative min-h-screen flex flex-col items-center justify-center p-4">
        <div class="w-full max-w-2xl bg-white rounded-lg overflow-hidden shadow-xl">
            <div class="bg-blue-500 p-4 text-white flex justify-between items-center">
                <h3 class="text-lg font-bold">Scanner Barcode</h3>
                <button onclick="closeModal('{{ $id }}')" class="text-white hover:text-blue-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <div id="interactive" class="viewport w-full h-64 md:h-96 bg-gray-200 relative overflow-hidden">
                </div>
                <div class="mt-4 text-center text-white">
                    <p>Arahkan kamera ke barcode produk</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/scanner.js') }}"></script>
