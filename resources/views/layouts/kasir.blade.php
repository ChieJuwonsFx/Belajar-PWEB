<x-app-layout>
    <header
        class="fixed top-3 left-4 right-4 z-40 bg-white rounded-xl shadow-md shadow-primary border border-gray-100 mx-auto max-w-[95vw]">
        <div class="px-4 py-2 md:px-6 md:py-3 flex items-center justify-between">
            <div class="flex items-center gap-2 md:gap-4">
                <button id="mobile-menu-button" class="text-dark hover:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-7 md:w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <a href="#" class="flex items-center group">
                    <div
                        class="w-8 h-8 md:w-9 md:h-9 rounded-lg bg-primary flex items-center justify-center mr-2 md:mr-3 group-hover:rotate-12 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 text-white"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-lg md:text-2xl font-bold bg-clip-text text-primary">InnoVixus</span>
                </a>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative">
                    @auth
                        <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none group">
                            <div class="relative">
                                @php
                                    $imagePath = '';

                                    if (is_string(auth()->user()->image)) {
                                        if (Str::startsWith(auth()->user()->image, ['http://', 'https://'])) {
                                            $imagePath = auth()->user()->image;
                                        } else {
                                            if (!Str::contains(auth()->user()->image, 'storage/')) {
                                                $imagePath = asset('storage/' . auth()->user()->image);
                                            } else {
                                                $imagePath = asset(ltrim(auth()->user()->image, '/'));
                                            }
                                        }
                                    } elseif (is_array(auth()->user()->image)) {
                                        $imagePath =
                                            auth()->user()->image['path'] ?? (auth()->user()->image['url'] ?? '');

                                        if ($imagePath && !Str::startsWith($imagePath, ['http://', 'https://'])) {
                                            if (!Str::contains($imagePath, 'storage/')) {
                                                $imagePath = asset('storage/' . $imagePath);
                                            } else {
                                                $imagePath = asset(ltrim($imagePath, '/'));
                                            }
                                        }
                                    }
                                @endphp

                                <img class="w-9 h-9 md:w-10 md:h-10 rounded-full border-2 border-white shadow-md group-hover:border-primary transition-colors"
                                    src="{{ $imagePath ?: asset('images/default-user.png') }}" alt="User profile"
                                    onerror="this.src='{{ asset('images/default-user.png') }}'">
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-sm md:text-base font-medium text-primary leading-4">
                                    {{ auth()->user()->name }}</p>
                                <p class="text-xs md:text-sm text-primary leading-3">{{ auth()->user()->role }}</p>
                            </div>
                        </button>

                        <div id="user-dropdown"
                            class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg py-2 z-50 border border-gray-100">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-dark">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('kasir.profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition">Your
                                Profile</a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <aside id="sidebar"
        class="bg-primary shadow-md shadow-black fixed top-0 left-0 z-30 w-64 h-screen pt-16 transform -translate-x-full transition-transform duration-200 ease-in-out sidebar-gradient text-white">
        <div class="h-full overflow-y-auto px-4 py-6 flex flex-col">
            <button id="close-sidebar-button" class="absolute top-4 right-4 text-white hover:text-blue-200 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <ul class="space-y-1.5 flex-1">
                <li>
                    <a href="{{ route('kasir.dashboard') }}"
                        class="flex items-center p-3 rounded-lg nav-item transition-all duration-200">
                        <div class="w-6 h-6 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kasir.transaksi') }}"
                        class="flex items-center p-3 rounded-lg nav-item transition-all duration-200">
                        <div class="w-6 h-6 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                                </path>
                            </svg>
                        </div>
                        <span class="font-medium">Transaksi</span>
                    </a>
                </li>
                <li>
                    <button id="sales-menu-button"
                        class="flex items-center justify-between w-full p-3 rounded-lg nav-item transition-all duration-200">
                        <div class="flex items-center">
                            <div class="w-6 h-6 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="font-medium">Sales</span>
                        </div>
                        <svg id="sales-menu-arrow" class="w-4 h-4 text-blue-300 transition-transform duration-200"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="sales-menu" class="py-1 pl-11 hidden space-y-1">
                        <li>
                            <a href="{{ route('kasir.transaksi.riwayat') }}"
                                class="flex items-center p-2 text-blue-200 hover:text-white rounded-lg submenu-item transition-all duration-200">
                                <span class="text-sm">Riwayat Transaksi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('kasir.transaksi.batal') }}"
                                class="flex items-center p-2 text-blue-200 hover:text-white rounded-lg submenu-item transition-all duration-200">
                                <span class="text-sm">Transaksi Dibatalkan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('kasir.transaksi.selesai') }}"
                                class="flex items-center p-2 text-blue-200 hover:text-white rounded-lg submenu-item transition-all duration-200">
                                <span class="text-sm">Transaksi Selesai</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="pt-4 mt-auto border-t border-blue-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full p-3 rounded-lg nav-item transition-all duration-200 text-left">
                        <div class="w-6 h-6 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="pt-16 min-h-screen transition-all duration-200" id="main-content">
        <div class="p-4">
            {{ $slot }}
        </div>
    </main>

    <script>
        $(document).ready(function() {
            const sidebarState = localStorage.getItem('sidebarState');
            if (sidebarState === 'open') {
                openSidebar();
            } else if (sidebarState === 'closed') {
                closeSidebar();
            } else {
                if (window.innerWidth >= 1024) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            }

            $('#mobile-menu-button').click(function(e) {
                e.stopPropagation();
                toggleSidebar();
            });

            $('#close-sidebar-button').click(function(e) {
                e.stopPropagation();
                closeSidebar();
            });

            $('#user-menu-button').click(function(e) {
                e.stopPropagation();
                $('#user-dropdown').toggleClass('hidden');
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('#user-menu-button, #user-dropdown').length) {
                    $('#user-dropdown').addClass('hidden');
                }
            });

            function setupMenuDropdown(buttonId, menuId, arrowId) {
                $(buttonId).click(function(e) {
                    e.stopPropagation();
                    $(menuId).toggleClass('hidden');
                    $(arrowId).toggleClass('rotate-180');

                    $('[id$="-menu"]').not(menuId).addClass('hidden');
                    $('[id$="-menu-arrow"]').not(arrowId).removeClass('rotate-180');
                });
            }

            setupMenuDropdown('#pages-menu-button', '#pages-menu', '#pages-menu-arrow');
            setupMenuDropdown('#sales-menu-button', '#sales-menu', '#sales-menu-arrow');
            setupMenuDropdown('#auth-menu-button', '#auth-menu', '#auth-menu-arrow');

            $(window).resize(function() {
                if (window.innerWidth >= 1024) {
                    openSidebar();
                }
            });

            function toggleSidebar() {
                if ($('#sidebar').hasClass('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            }

            function openSidebar() {
                $('#sidebar').removeClass('-translate-x-full');
                $('#main-content').addClass('lg:ml-64');
                localStorage.setItem('sidebarState', 'open');
            }

            function closeSidebar() {
                $('#sidebar').addClass('-translate-x-full');
                $('#main-content').removeClass('lg:ml-64');
                localStorage.setItem('sidebarState', 'closed');
            }
        });
    </script>
</x-app-layout>
