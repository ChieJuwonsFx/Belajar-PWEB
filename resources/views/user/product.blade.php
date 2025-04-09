<x-user>
    <section class=" py-8 antialiased md:py-12">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
          <!-- Heading & Filters -->
          <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
            <div>
              <h2 class="mt-3 text-xl font-semibold text-gray-900 sm:text-2xl">Electronics</h2>
            </div>
            <div class="flex items-center space-x-4">
              {{-- <button data-modal-toggle="filterModal" data-modal-target="filterModal" type="button" class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100  sm:w-auto">
                <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                </svg>
                Filters
                <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                </svg>
              </button> --}}
              <button id="sortDropdownButton1" data-dropdown-toggle="dropdownSort1" type="button" class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100  sm:w-auto">
                <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                  </svg>
                  Filters
                  <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                  </svg>
              </button>
              <button id="sortDropdownButton2" data-dropdown-toggle="dropdownSort2" type="button" class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100  sm:w-auto">
                <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M7 4l3 3M7 4 4 7m9-3h6l-6 6h6m-6.5 10 3.5-7 3.5 7M14 18h4" />
                </svg>
                Sort
                <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                </svg>
              </button>
              <div id="dropdownSort2" class="z-50 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow" data-popper-placement="bottom">
                <ul class="p-2 text-left text-sm font-medium text-gray-500 " aria-labelledby="sortDropdownButton">
                  <li>
                    <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 "> The most popular </a>
                  </li>
                  <li>
                    <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 "> Newest </a>
                  </li>
                  <li>
                    <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 "> Increasing price </a>
                  </li>
                  <li>
                    <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 "> Decreasing price </a>
                  </li>
                  <li>
                    <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 "> No. reviews </a>
                  </li>
                  <li>
                    <a href="#" class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 "> Discount % </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        {{-- @foreach ($products as $product)
        <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
              <div class="h-56 w-full">
                <a href="#">
                    @if (!empty($product->image) && isset($product->image[0]['path']))
                        <img src="{{ Str::startsWith($product->image[0]['path'], 'http') ? $product->image[0]['path'] : asset('storage/'.$product->image[0]['path']) }}" class="h-16 object-cover rounded" alt="">
                    @endif
                </a>
              </div>
              <div class="pt-6">
                <div class="mb-4 flex items-center justify-between gap-4">
                  <span class="me-2 rounded bg-primary px-2.5 py-0.5 text-xs font-medium text-white"> Up to 35% off </span>
      
                  <div class="flex items-center justify-end gap-1">
                    <button type="button" data-tooltip-target="tooltip-quick-look" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 ">
                      <span class="sr-only"> Quick look </span>
                      <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                      </svg>
                    </button>
                    <div id="tooltip-quick-look" role="tooltip" class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300" data-popper-placement="top">
                      Quick look
                      <div class="tooltip-arrow" data-popper-arrow=""></div>
                    </div>
      
                    <button type="button" data-tooltip-target="tooltip-add-to-favorites" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 ">
                      <span class="sr-only"> Add to Favorites </span>
                      <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6C6.5 1 1 8 5.8 13l6.2 7 6.2-7C23 8 17.5 1 12 6Z" />
                      </svg>
                    </button>
                    <div id="tooltip-add-to-favorites" role="tooltip" class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300" data-popper-placement="top">
                      Add to favorites
                      <div class="tooltip-arrow" data-popper-arrow=""></div>
                    </div>
                  </div>
                </div>
      
                <a href="#" class="text-lg font-semibold leading-tight text-gray-900 hover:underline">{{ $product->name }}</a>

                <div class="mt-4 flex items-center justify-between gap-4">
                  <p class="text-2xl font-extrabold leading-tight text-gray-900">{{ $product->harga_jual }}</p>
      
                  <button type="button" class="inline-flex items-center rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary focus:outline-none focus:ring-4  focus:ring-primary">
                    <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                    </svg>
                    Add to cart
                  </button>
                </div>
              </div>
            </div>
        @endforeach --}}


          {{-- <div class="w-full text-center">
            <button type="button" class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 ">Show more</button>
          </div> --}}
        </div>
        <div id="dropdownSort1" class="z-50 hidden w-48 divide-y divide-gray-100 rounded-lg bg-white shadow" data-popper-placement="bottom">
            <h3 class="mb-2 text-sm font-medium text-gray-900">Brand</h3>
            <div class="grid grid-cols-3 p-3">
              <ul class="space-y-2 text-sm" aria-labelledby="sortDropdownButton1">
                <li class="flex items-center">
                  <input id="apple-filter" type="checkbox" value="" class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-primary focus:ring-2 focus:ring-primary">
                  <label for="apple-filter" class="ml-2 text-sm font-medium text-gray-900">Apple (56)</label>
                </li>
                <li class="flex items-center">
                  <input id="samsung-filter" type="checkbox" value="" class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-primary focus:ring-2 focus:ring-primary">
                  <label for="samsung-filter" class="ml-2 text-sm font-medium text-gray-900">Samsung (24)</label>
                </li>
                <li class="flex items-center">
                  <input id="microsoft-filter" type="checkbox" value="" class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-primary focus:ring-2 focus:ring-primary">
                  <label for="microsoft-filter" class="ml-2 text-sm font-medium text-gray-900">Microsoft (18)</label>
                </li>
                <li class="flex items-center">
                  <input id="dell-filter" type="checkbox" value="" class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-primary focus:ring-2 focus:ring-primary">
                  <label for="dell-filter" class="ml-2 text-sm font-medium text-gray-900">Dell (12)</label>
                </li>
              </ul>
            </div>
            <div class="p-3">
              <h3 class="mb-2 text-sm font-medium text-gray-900">Price</h3>
              <div class="flex items-center space-x-4">
                <div class="relative">
                  <input type="number" id="min-price" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-1.5 text-sm text-gray-900 focus:border-primary focus:ring-primary" placeholder="Min">
                </div>
                <span class="text-gray-500">to</span>
                <div class="relative">
                  <input type="number" id="max-price" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-1.5 text-sm text-gray-900 focus:border-primary focus:ring-primary" placeholder="Max">
                </div>
              </div>
            </div>
            <div class="p-3">
              <button type="button" class="w-full rounded-lg bg-primary px-3 py-2 text-center text-sm font-medium text-white hover:bg-primary focus:outline-none focus:ring-4 focus:ring-primary">Apply Filters</button>
            </div>
          </div>
      </section>
</x-user>