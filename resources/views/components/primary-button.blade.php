{{-- <button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}> --}}
    
{{-- </button> --}}
{{-- <button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-center inline-flex items-center text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button> --}}

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-primary bg-white border border-primary hover:bg-primary  hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
