<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="../../css/app.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@1.5.2/dist/flowbite.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/flowbite@1.5.0/dist/flowbite.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
<body class="antialiased bg-white min-h-screen flex items-center justify-center">
    <section class="bg-white">
        <div class="flex grid-cols-2 py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6 items-center justify-beetween">
            <div class="mx-auto max-w-screen-sm text-center">
                <h1 class="mb-4 text-6xl tracking-tight font-extrabold lg:text-9xl text-blue-500">@yield('code')</h1>
                <p class="mb-4 text-3xl tracking-tight font-bold text-secondary md:text-4xl">@yield('title')</p>
                <p class="mb-4 text-lg font-light text-secondary">@yield('message')</p>
                <a onclick="history.back(); return false;" class="cursor-pointer inline-flex text-white bg-blue-500 border border-blue-500 hover:bg-white hover:text-blue-500 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center my-4">
                    Back to Previous Page
                </a>
            </div>   
            <div class="mx-auto max-w-screen-sm text-center h-3/6 w-3/6">
                <img src="@yield('image')" alt="@yield('title')">
            </div>  
        </div>
    </section>
</body>
</html>
