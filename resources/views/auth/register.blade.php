<x-app-layout>
    <section class="min-h-screen flex items-center justify-center bg-sky-100 bg-opacity-30 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6 md:p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-primary md:text-3xl">Welcome</h1>
                <p class="text-sm text-gray-600 mt-1">Make your account!</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <x-secondary-button  class="w-full mt-2">
                    {{ __('Register') }}
                </x-secondary-button>

                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-primary underline">
                        {{ __('Already registered?') }}
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <!-- Google Login -->
                    <button type="button" onclick="window.location.href='{{ route('auth.google') }}'" class="flex items-center justify-center gap-2 w-full h-11 bg-white border border-primary text-primary hover:bg-primary hover:text-white rounded-lg text-sm px-4 transition ease-in-out duration-150">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12.037 21.998a10.313 10.313 0 0 1-7.168-3.049 9.888 9.888 0 0 1-2.868-7.118 9.947 9.947 0 0 1 3.064-6.949A10.37 10.37 0 0 1 12.212 2h.176a9.935 9.935 0 0 1 6.614 2.564L16.457 6.88a6.187 6.187 0 0 0-4.131-1.566 6.9 6.9 0 0 0-4.794 1.913 6.618 6.618 0 0 0-2.045 4.657 6.608 6.608 0 0 0 1.882 4.723 6.891 6.891 0 0 0 4.725 2.07h.143c1.41.072 2.8-.354 3.917-1.2a5.77 5.77 0 0 0 2.172-3.41l.043-.117H12.22v-3.41h9.678c.075.617.109 1.238.1 1.859-.099 5.741-4.017 9.6-9.746 9.6l-.215-.002Z" clip-rule="evenodd"/>
                        </svg>
                        Google
                    </button>

                    <!-- Facebook Login -->
                    <button type="button" class="flex items-center justify-center gap-2 w-full h-11 bg-white border border-primary text-primary hover:bg-primary hover:text-white rounded-lg text-sm px-4 transition ease-in-out duration-150">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z" clip-rule="evenodd"/>
                        </svg>
                        Facebook
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
