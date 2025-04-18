<x-app-layout>
    <header class="fixed top-3 left-4 right-4 z-40 bg-white rounded-xl shadow-md shadow-primary border border-gray-100 mx-auto max-w-[95vw]">
        <div class="px-4 py-2 md:px-6 md:py-3 flex items-center justify-between">
            <div class="flex items-center gap-2 md:gap-4">
                <button id="mobile-menu-button" class="md:hidden text-dark hover:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-7 md:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <a href="#" class="flex items-center group">
                    <div class="w-8 h-8 md:w-9 md:h-9 rounded-lg bg-primary flex items-center justify-center mr-2 md:mr-3 group-hover:rotate-12 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-lg md:text-2xl font-bold bg-clip-text text-primary">InnoVixus</span>
                </a>
            </div>
   
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none group">
                        <div class="relative">
                            <img class="w-9 h-9 md:w-10 md:h-10 rounded-full border-2 border-white shadow-md group-hover:border-primary transition-colors"
                                src="https://randomuser.me/api/portraits/women/44.jpg" alt="User profile">
                        </div>
                        <div class="hidden sm:block text-left">
                            <p class="text-sm md:text-base font-medium text-primary leading-4">Sarah Johnson</p>
                            <p class="text-xs md:text-sm text-primary leading-3">Admin</p>
                        </div>
                    </button>
    
                    <div id="user-dropdown"
                        class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg py-2 z-50 border border-gray-100">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-medium text-dark">Sarah Johnson</p>
                            <p class="text-xs text-gray-500">sarah@nexus.example</p>
                        </div>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition">Your
                            Profile</a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition">Settings</a>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <aside id="sidebar" class="bg-primary shadow-md shadow-black fixed top-0 left-0 z-30 w-64 h-screen pt-16 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out sidebar-gradient text-white">
        <div class="h-full overflow-y-auto px-4 py-6 flex flex-col">
            <ul class="space-y-1.5 flex-1">
                <li>
                    <a href="{{ route('owner') }}" class="flex items-center p-3 rounded-lg nav-item transition-all duration-200">
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
                    <button id="pages-menu-button" class="flex items-center justify-between w-full p-3 rounded-lg nav-item transition-all duration-200">
                        <div class="flex items-center">
                            <div class="w-6 h-6 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="font-medium">Kelola Produk</span>
                        </div>
                        <svg id="pages-menu-arrow" class="w-4 h-4 text-blue-300 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="pages-menu" class="py-1 pl-11 hidden space-y-1">
                        <li>
                            <a href="{{ route('owner.produk') }}" class="flex items-center p-2 text-blue-200 hover:text-white rounded-lg submenu-item transition-all duration-200">
                                <span class="text-sm">Produk</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('owner.kategori') }}" class="flex items-center p-2 text-blue-200 hover:text-white rounded-lg submenu-item transition-all duration-200">
                                <span class="text-sm">Kelola Kategori</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('owner.unit') }}" class="flex items-center p-2 text-blue-200 hover:text-white rounded-lg submenu-item transition-all duration-200">
                                <span class="text-sm">Kelola Unit</span>
                            </a>
                        </li>
                    </ul>
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
                            <a href="#"
                                class="flex items-center p-2 text-blue-200 hover:text-white rounded-lg submenu-item transition-all duration-200">
                                <span class="text-sm">Orders</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center p-2 text-blue-200 hover:text-white rounded-lg submenu-item transition-all duration-200">
                                <span class="text-sm">Billing</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center p-2 text-blue-200 hover:text-white rounded-lg submenu-item transition-all duration-200">
                                <span class="text-sm">Reports</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('employee') }}"
                        class="flex items-center p-3 rounded-lg nav-item transition-all duration-200">
                        <div class="w-6 h-6 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                        </div>
                        <span class="font-medium">Team</span>
                    </a>
                </li>

                <li>
                    <button id="auth-menu-button"
                        class="flex items-center justify-between w-full p-3 rounded-lg nav-item transition-all duration-200">
                        <div class="flex items-center">
                            <div class="w-6 h-6 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="font-medium">Authentication</span>
                        </div>
                        <svg id="auth-menu-arrow" class="w-4 h-4 text-blue-300 transition-transform duration-200"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="auth-menu" class="py-1 pl-11 hidden space-y-1">
                        <li>
                            <a href="#"
                                class="flex items-center p-2 text-blue-200 hover:text-white rounded-lg submenu-item transition-all duration-200">
                                <span class="text-sm">Sign In</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center p-2 text-blue-200 hover:text-white rounded-lg submenu-item transition-all duration-200">
                                <span class="text-sm">Sign Up</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center p-2 text-blue-200 hover:text-white rounded-lg submenu-item transition-all duration-200">
                                <span class="text-sm">Forgot Password</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="pt-4 mt-auto border-t border-blue-700">
                <ul class="space-y-1.5">
                    <li>
                        <a href="#"
                            class="flex items-center p-3 rounded-lg nav-item transition-all duration-200">
                            <div class="w-6 h-6 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="font-medium">Settings</span>
                        </a>
                    </li>
                    <li>
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
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <div id="sidebar-overlay" class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden hidden"></div>

    <main class="md:ml-64 pt-16 min-h-screen">
        <div class="p-4">
            {{ $slot }}
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#mobile-menu-button').click(function(e) {
                e.stopPropagation();
                $('#sidebar').toggleClass('-translate-x-full');
                $('#sidebar-overlay').toggleClass('hidden');
            });

            $('#sidebar-overlay').click(function() {
                $('#sidebar').addClass('-translate-x-full');
                $('#sidebar-overlay').addClass('hidden');
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
        });
    </script>
</x-app-layout>