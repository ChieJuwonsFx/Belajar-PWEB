@props([
    'id',
    'title' => 'Warning!',
    'message' => '',
    'route' => '#',
    'name' => '',
    'buttonText' => 'Ya, Lanjutkan',
    'cancelText' => 'Batal'
])
<div id="{{ $id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 transition-opacity" onclick="closeModal('{{ $id }}')"></div>
    <div class="bg-white rounded-xl z-40 shadow-2xl max-w-md w-full p-6">
        <div class="text-center">
            <div id="dangerLottie-{{ $id }}" class="mx-auto w-32 h-32 mb-4"></div>
            <h2 class="text-2xl font-bold text-red-700 mb-2">{{ $title }}</h2>
            <p class="text-gray-700 mb-4">
                {!! str_replace(':name', "<span class='font-semibold'>$name</span>", $message) !!}
            </p>
            <div class="flex justify-center gap-4">
                <button onclick="closeModal('{{ $id }}')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg">
                    {{ $cancelText }}
                </button>
                <a href="{{ $route }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg">
                    {{ $buttonText }}
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const id = '{{ $id }}';
        if (!document.getElementById('dangerLottie-' + id).hasChildNodes()) {
            lottie.loadAnimation({
                container: document.getElementById('dangerLottie-' + id),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: '{{ asset('assets/danger.json') }}'
            });
        }
    });
</script>



