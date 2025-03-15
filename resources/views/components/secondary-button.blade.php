<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-white border border-primary bg-primary hover:bg-white hover:text-primary hover:border-primary focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-4 py-2 text-center']) }}>
    {{ $slot }}
</button>
