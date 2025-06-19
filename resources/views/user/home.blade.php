<x-user>
    <section class="bg-white flex items-center justify-center mx-auto h-screen">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="flex w-full lg:w-1/2 justify-center">
                    <img src="https://img.pikbest.com/png-images/20240713/funny-cute-panda-clipart_10665937.png!w700wp"
                        alt="Manajemen Toko dan Kasir" class="w-auto h-80 rounded-lg " />
                </div>
                <div class="w-full text-center lg:text-left">
                    <h1
                        class="mb-5 text-4xl font-extrabold tracking-tight leading-none text-primary md:text-5xl lg:text-6xl">
                        InnoVixus: Solusi Manajemen Toko & Kasir Modern dengan FIFO!
                    </h1>
                    <p class="mb-6 text-lg font-normal text-secondary lg:text-xl">
                        Optimalkan stok dan penjualan Anda dengan sistem First-In, First-Out (FIFO) yang cerdas, memastikan produk terlama terjual lebih dulu.
                    </p>
                    <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center lg:justify-start sm:space-y-0">
                        <a href="{{ route('login') }}"
                            class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-white rounded-lg bg-primary hover:bg-white hover:text-primary border border-primary hover:border-primary focus:ring-4 focus:outline-none">
                            Mulai Sekarang!
                            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="py-5 px-8 my-4 mx-auto max-w-screen-xl">
        <div class="mb-8">
            <h1
                class="mb-4 text-center text-4xl font-bold leading-none tracking-tight text-primary md:text-5xl lg:text-5xl">
                Fitur Utama <span class="text-terti">InnoVixus</span>
            </h1>
            <p class="text-lg mx-6 text-center font-normal text-secondary lg:text-xl">
                InnoVixus hadir dengan berbagai fitur canggih untuk membantu Anda mengelola toko dan kasir dengan efisien.
            </p>
        </div>
        <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-2">
            <article class="p-6 bg-white rounded-lg border border-primary shadow-md">
                <div class="flex justify-between items-center mb-5 text-primary">
                    <span class="text-primary text-l font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                        <svg class="mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        Manajemen Stok FIFO
                    </span>
                </div>
                <img src="https://plus.unsplash.com/premium_photo-1664474619075-644dd191935f?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aW1hZ2V8ZW58MHx8MHx8fDA%3D" {{-- Placeholder, ganti dengan ikon/ilustrasi fitur --}}
                    alt="Manajemen Stok FIFO" class="rounded-lg mb-4 border-solid border border-primary" />
                <h2
                    class="mb-2 text-2xl font-bold tracking-tight text-primary hover:text-terti  line-clamp-2 min-h-[2.5rem]">
                    Kelola Stok dengan Cerdas
                </h2>
                <p class="mb-5 font-normal text-secondary line-clamp-2">Secara otomatis mengatur dan melacak inventaris Anda berdasarkan urutan masuk, memastikan produk lama terjual terlebih dahulu.</p>
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        {{-- <img class="w-7 h-7 rounded-full" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/jese-leos.png" /> --}}
                        <span class="font-medium text-primary">Optimalisasi Persediaan</span>
                    </div>
                </div>
            </article>

            <article class="p-6 bg-white rounded-lg border border-primary shadow-md">
                <div class="flex justify-between items-center mb-5 text-primary">
                    <span class="text-primary text-l font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                        <svg class="mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM6.5 9.5a1 1 0 100 2h7a1 1 0 100-2h-7z" clip-rule="evenodd"></path>
                        </svg>
                        Sistem Kasir Terintegrasi
                    </span>
                </div>
                <img src="https://plus.unsplash.com/premium_photo-1664474619075-644dd191935f?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aW1hZ2V8ZW58MHx8MHx8fDA%3D" {{-- Placeholder, ganti dengan ikon/ilustrasi fitur --}}
                    alt="Sistem Kasir Terintegrasi" class="rounded-lg mb-4 border-solid border border-primary" />
                <h2
                    class="mb-2 text-2xl font-bold tracking-tight text-primary hover:text-terti  line-clamp-2 min-h-[2.5rem]">
                    Transaksi Cepat & Akurat
                </h2>
                <p class="mb-5 font-normal text-secondary line-clamp-2">Proses penjualan dengan mudah, catat transaksi secara real-time, dan hasilkan laporan penjualan yang komprehensif.</p>
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <span class="font-medium text-primary">Efisiensi Transaksi</span>
                    </div>
                </div>
            </article>

            <article class="p-6 bg-white rounded-lg border border-primary shadow-md">
                <div class="flex justify-between items-center mb-5 text-primary">
                    <span class="bg-primary-100 hover:underline text-primary text-l font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                        <svg class="mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                        </svg>
                        Laporan & Analisis
                    </span>
                </div>
                <img src="https://plus.unsplash.com/premium_photo-1664474619075-644dd191935f?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aW1hZ2V8ZW58MHx8MHx8fDA%3D" {{-- Placeholder, ganti dengan ikon/ilustrasi fitur --}}
                    alt="Laporan & Analisis" class="rounded-lg mb-4 border-solid border border-primary" />
                <h2
                    class="mb-2 text-2xl font-bold tracking-tight text-primary hover:text-terti  line-clamp-2 min-h-[2.5rem]">
                    Insight Bisnis Mendalam
                </h2>
                <p class="mb-5 font-normal text-secondary line-clamp-2">Dapatkan laporan penjualan, stok, dan keuntungan secara real-time untuk pengambilan keputusan yang lebih baik.</p>
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <span class="font-medium text-primary">Pengambilan Keputusan</span>
                    </div>
                </div>
            </article>
        </div>
    </div>

    {{-- Bagian "Designed for business teams like yours" diubah menjadi "Mengapa Memilih InnoVixus?" --}}
    <section class="bg-primary">
        <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
            <div class="max-w-screen-md mb-8 lg:mb-10">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-white">Mengapa Memilih InnoVixus?</h2>
                <p class="text-white sm:text-xl">InnoVixus dirancang khusus untuk memenuhi kebutuhan manajemen toko modern, dengan fokus pada efisiensi dan akurasi.</p>
            </div>
            <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-8 md:space-y-0">
                <div>
                    <div class="flex justify-center items-center w-10 h-10 rounded-full bg-white lg:h-12 lg:w-12"> {{-- Ubah warna background ikon agar terlihat --}}
                        <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-white">Manajemen Stok Akurat</h3> {{-- Tambahkan text-white --}}
                    <p class="text-white">Implementasi FIFO yang presisi untuk menghindari kerugian akibat stok kedaluwarsa atau usang.</p>
                </div>
                <div>
                    <div class="flex justify-center items-center w-10 h-10 rounded-full bg-white lg:h-12 lg:w-12">
                        <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path></svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-white">Antarmuka Pengguna Intuitif</h3>
                    <p class="text-white">Mudah digunakan oleh siapa saja, dari pemilik toko hingga kasir, tanpa pelatihan ekstensif.</p>
                </div>
                <div>
                    <div class="flex justify-center items-center w-10 h-10 rounded-full bg-white lg:h-12 lg:w-12">
                        <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path></svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-white">Hemat Waktu & Biaya</h3>
                    <p class="text-white">Otomatisasi proses manual mengurangi kesalahan dan meningkatkan produktivitas.</p>
                </div>
                <div>
                    <div class="flex justify-center items-center w-10 h-10 rounded-full bg-white lg:h-12 lg:w-12">
                        <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-white">Analisis Penjualan Mendalam</h3>
                    <p class="text-white">Dapatkan laporan terperinci untuk mengidentifikasi tren, produk terlaris, dan kinerja toko secara keseluruhan.</p>
                </div>
                <div>
                    <div class="flex justify-center items-center w-10 h-10 rounded-full bg-white lg:h-12 lg:w-12">
                        <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-white">Dukungan Multi-Platform</h3>
                    <p class="text-white">Akses aplikasi dari perangkat apapun, kapan saja, untuk manajemen yang fleksibel.</p>
                </div>
                <div>
                    <div class="flex justify-center items-center w-10 h-10 rounded-full bg-white lg:h-12 lg:w-12">
                        <svg class="w-5 h-5 text-primary-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-white">Dukungan Pelanggan Prima</h3>
                    <p class="text-white">Tim dukungan kami siap membantu Anda kapan saja untuk memastikan kelancaran operasional.</p>
                </div>
            </div>
        </div>
      </section>

    {{-- Bagian testimoni tetap bisa digunakan, namun sesuaikan teksnya --}}
    <div class="py-4 px-8 mt-24 mx-auto max-w-screen-xl">
        <div class="text-center">
            <h1 class="mb-4 text-4xl font-bold leading-none tracking-tight text-primary">Dengarkan apa kata <mark
                    class="px-2 text-primary bg-terti rounded-lg">pengguna kami</mark></h1>
            <p class="text-lg font-normal text-secondary lg:text-xl">
                Pengalaman nyata dari pemilik toko yang telah merasakan manfaat InnoVixus.
            </p>
        </div>
        <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 py-4 px-8 my-4 mx-auto max-w-screen-xl">
            <figure class="max-w-screen-md">
                <div class="flex items-center mb-4 text-yellow-300">
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                </div>
                <blockquote>
                    <p class="text-l font-semibold text-primary">"InnoVixus benar-benar mengubah cara saya mengelola stok. Sistem FIFO-nya sangat membantu mengurangi produk kedaluwarsa dan meningkatkan profitabilitas toko saya."</p>
                </blockquote>
                <figcaption class="flex items-center mt-6 space-x-3 rtl:space-x-reverse">
                    <img class="w-6 h-6 rounded-full"
                        src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png"
                        alt="profile picture">
                    <div class="flex items-center divide-x-2 rtl:divide-x-reverse divide-secondary ">
                        <cite class="pe-3 font-medium text-primary">Ani Suryani</cite>
                        <cite class="ps-3 text-sm text-secondary">Pemilik Toko Kelontong "Berkah"</cite>
                    </div>
                </figcaption>
            </figure>
            <figure class="max-w-screen-md">
                <div class="flex items-center mb-4 text-yellow-300">
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                </div>
                <blockquote>
                    <p class="text-l font-semibold text-primary">"Sebagai kasir, saya sangat terbantu dengan antarmuka yang user-friendly dan kecepatan proses transaksi. Laporan penjualan juga sangat detail!"</p>
                </blockquote>
                <figcaption class="flex items-center mt-6 space-x-3 rtl:space-x-reverse">
                    <img class="w-6 h-6 rounded-full"
                        src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png"
                        alt="profile picture">
                    <div class="flex items-center divide-x-2 rtl:divide-x-reverse divide-secondary ">
                        <cite class="pe-3 font-medium text-primary">Budi Santoso</cite>
                        <cite class="ps-3 text-sm text-secondary">Kasir di Supermarket "Maju Bersama"</cite>
                    </div>
                </figcaption>
            </figure>
            <figure class="max-w-screen-md">
                <div class="flex items-center mb-4 text-yellow-300">
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 22 20">
                        <path
                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                </div>
                blockquote>
                    <p class="text-l font-semibold text-primary">"Dengan InnoVixus, saya merasa lebih tenang karena inventaris saya selalu teratur. Saya tidak perlu khawatir lagi tentang barang yang mendekati tanggal kedaluwarsa!"</p>
                </blockquote>
                <figcaption class="flex items-center mt-6 space-x-3 rtl:space-x-reverse">
                    <img class="w-6 h-6 rounded-full"
                        src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png"
                        alt="profile picture">
                    <div class="flex items-center divide-x-2 rtl:divide-x-reverse divide-secondary ">
                        <cite class="pe-3 font-medium text-primary">Citra Dewi</cite>
                        <cite class="ps-3 text-sm text-secondary">Pemilik Minimarket "Cepat Laris"</cite>
                    </div>
                </figcaption>
            </figure>
        </div>
    </div>
</x-user>
