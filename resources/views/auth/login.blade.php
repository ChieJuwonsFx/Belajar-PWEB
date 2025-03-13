<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <section>
        <div class="flex flex-col items-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow-md sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div>
                        <h1 class="text-xl font-bold  text-center text-gray-900 md:text-2xl ">
                            Welcome Back!!!
                        </h1>
                        <p class="text-center text-sm">
                            Sign in to your account
                        </p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <label for="remember_me" class="text-sm text-gray-600 ms-2">{{ __('Remember me') }}</label>
                            </div>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>

                        
                        <x-primary-button class="w-full mt-4">
                            {{ __('Log in') }}
                        </x-primary-button>


                        <p class="text-sm font-light text-center text-gray-500 mt-4">
                            Don’t have an account yet? <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:underline">Sign up</a>
                        </p>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <button type="button" onclick="window.location.href='{{ route('auth.google') }}'" class="flex items-center justify-center gap-2 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full py-2.5 hover:bg-primary-700 focus:ring-4 focus:outline-none">
                                    <svg class="w-5 h-5 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12.037 21.998a10.313 10.313 0 0 1-7.168-3.049 9.888 9.888 0 0 1-2.868-7.118 9.947 9.947 0 0 1 3.064-6.949A10.37 10.37 0 0 1 12.212 2h.176a9.935 9.935 0 0 1 6.614 2.564L16.457 6.88a6.187 6.187 0 0 0-4.131-1.566 6.9 6.9 0 0 0-4.794 1.913 6.618 6.618 0 0 0-2.045 4.657 6.608 6.608 0 0 0 1.882 4.723 6.891 6.891 0 0 0 4.725 2.07h.143c1.41.072 2.8-.354 3.917-1.2a5.77 5.77 0 0 0 2.172-3.41l.043-.117H12.22v-3.41h9.678c.075.617.109 1.238.1 1.859-.099 5.741-4.017 9.6-9.746 9.6l-.215-.002Z" clip-rule="evenodd"/>
                                    </svg>
                                    Google
                                </button>
                            </div>

                            <!-- Facebook Login -->
                            <div>
                                <button type="button" class="flex items-center justify-center gap-2 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full py-2.5 hover:bg-primary-700 focus:ring-4 focus:outline-none">
                                    <svg class="w-5 h-5 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z" clip-rule="evenodd"/>
                                    </svg>                                  
                                    Facebook
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
