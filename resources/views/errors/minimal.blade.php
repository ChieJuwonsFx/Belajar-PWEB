<x-app-layout>
    <div class="antialiased bg-white min-h-screen flex items-center justify-center">
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
    </div>
</x-app-layout>
