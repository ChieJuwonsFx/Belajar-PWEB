<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{{ csrf_token() }}}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="../../css/app.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.0/lottie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
</head>

<body>
    <div id="alertContainer" class="fixed top-4 right-4 z-[9999] space-y-2"></div>
    <main>
        {{ $slot }}
    </main>

    @if (session('alert_success'))
        <script>
            showAlert('success', @json(session('alert_success')));
        </script>
    @endif

    @if (session('alert_warning'))
        <script>
            showAlert('warning', @json(session('alert_warning')));
        </script>
    @endif

    @if (session('alert_failed'))
        <script>
            showAlert('failed', @json(session('alert_failed')));
        </script>
    @endif

    <script>
        function openModal(id) {
            document.getElementById(id)?.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(id) {
            document.getElementById(id)?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    </script>
</body>

</html>
