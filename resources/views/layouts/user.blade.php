<x-app_layout>
    <div class="bg-white text-white font-poppins"> 
        {{-- <x-navbarUser> </x-navbarUser> --}}
        @include('layouts.navbarUser')
        {{ $slot }}
    </div>
</x-app_layout>
