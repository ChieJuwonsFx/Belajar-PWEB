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
            <div id="dangerLottie-{{ $id }}" class="mx-auto w-32 h-32 mb-4">
                <svg class="w-full h-full text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-red-700 mb-2">{{ $title }}</h2>
            <p class="text-gray-700 mb-4">
                {!! str_replace(':name', "<span class='font-semibold'>$name</span>", $message) !!}
            </p>
            <div class="flex justify-center gap-4">
                <button onclick="closeModal('{{ $id }}')" class="h-10 w-24 bg-white border border-primary text-primary hover:bg-primary hover:text-white rounded-lg transition-colors">
                    {{ $cancelText }}
                </button>
                <button onclick="window.location.href='{{ $route }}'" class="h-10 w-24 bg-danger border border-danger hover:bg-white text-white hover:text-danger font-semibold rounded-lg transition-colors">
                    {{ $buttonText }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
if (!window.__lottieCache) {
    window.__lottieCache = {};
}

document.addEventListener('DOMContentLoaded', function () {
    const id = '{{ $id }}';
    const container = document.getElementById('dangerLottie-' + id);
    
    if (!container || container.hasChildNodes()) return;

    if (!window.__lottieCache.danger && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        lottie.loadAnimation({
            container: container,
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset('assets/danger.json') }}'
        });
        window.__lottieCache.danger = true;
    }
});

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('hidden');
    }
}
</script>