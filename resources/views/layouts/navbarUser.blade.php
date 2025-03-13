@if (Route::has('login'))
  <nav class="bg-white border-gray-200  sticky mt-3 w-full z-20">
    <div class="max-w-full flex flex-wrap items-center justify-between mx-auto py-3 px-4 lg:px-10 md:px-6 sm:px-4">
        <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
            {{-- <img src="" class="h-8" alt="" /> --}}
            <span class="self-center text-2xl font-semibold whitespace-nowrap text-primary">InnoVixus</span>
        </a>
        <button data-collapse-toggle="navbar-default" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul
                class="items-center font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white ">
                <li>
                    <a href="/"
                        class="{{ request()->is('/') ? 'text-primary relative md:after:content-[\'\'] md:after:absolute md:after:bottom-0 md:after:left-0 md:after:w-full md:after:h-1 md:after:bg-primary md:after:rounded-full' : 'text-secondary hover:text-primary' }} block py-2 px-3">
                        Home
                    </a>
                </li>
                <li>
                    <a href="/posts"
                        class="{{ request()->is('posts') ? 'text-primary relative md:after:content-[\'\'] md:after:absolute md:after:bottom-0 md:after:left-0 md:after:w-full md:after:h-1 md:after:bg-primary md:after:rounded-full' : 'text-secondary hover:text-primary' }} block py-2 px-3">
                        Blog
                    </a>
                </li>
                <li>
                    <a href="/bookmark"
                        class="{{ request()->is('bookmark') ? 'text-primary relative md:after:content-[\'\'] md:after:absolute md:after:bottom-0 md:after:left-0 md:after:w-full md:after:h-1 md:after:bg-primary md:after:rounded-full' : 'text-secondary hover:text-primary' }} block py-2 px-3">
                        Bookmark
                    </a>
                </li>
                @auth
                    <div class="flex space-x-2">
                        <form method="POST" action="{{ url('/dashboard') }}">
                            @csrf
                            <button type="submit"
                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                    @else
                      <div class="flex space-x-2">
                          <button type="button" onclick="window.location.href='{{ route('login') }}';"
                              class="text-primary bg-white border border-primary hover:bg-primary  hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">Login</button>
                          @if (Route::has('register'))
                            <button type="button" onclick="window.location.href='{{ route('register') }}';"
                              class="text-white border border-primary bg-primary hover:bg-white hover:text-primary hover:border-primary focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-4 py-2 text-center">Register</button>
                          @endif
                      </div>
                @endauth
                </li>
            </ul>
        </div>
    </div>
  </nav>
@endif



