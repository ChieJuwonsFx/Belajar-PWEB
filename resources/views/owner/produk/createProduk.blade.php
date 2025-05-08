<div id="add-produk" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm-opacity" onclick="closeModal('add-produk')"></div>
    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold">Tambah Produk Baru</h2>
                    <p class="text-primary-100">Isi Semua Form di Bawah Ini</p>
                </div>
                <button type="button" class="text-white hover:text-primary-100-colors"
                    onclick="closeModal('add-produk')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <form id="add-produk-form" action="{{ route('owner.produk.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nama Produk<span
                                class="text-danger">* </span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 @error('name') border-danger @enderror"
                            placeholder="Sanyo">
                        @error('name')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-700">Kategori<span
                                class="text-danger">* </span></label>
                        <select id="category" name="category" value="{{ old('category') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 @error('category') border-danger @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="stok" class="block mb-2 text-sm font-medium text-gray-700">Stok Awal</label>
                        <input type="number" name="stok" id="stok" value="{{ old('stok') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 @error('stok') border-danger @enderror"
                            placeholder="20">
                        @error('stok')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="stok_minimum" class="block mb-2 text-sm font-medium text-gray-700">Stok
                            Minimum<span class="text-danger">* </span></label>
                        <input type="number" name="stok_minimum" id="stok_minimum" value="{{ old('stok_minimum') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 @error('stok_minimum') border-danger @enderror"
                            placeholder="20">
                        @error('stok_minimum')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="unit" class="block mb-1 text-sm font-medium text-gray-700">Satuan
                            Produk<span class="text-danger">* </span></label>
                        <p class="block mb-2 text-xs text-gray-700">Pilih produk dijual dalam satuan apa.</p>
                        <select id="unit" name="unit"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 @error('unit') border-danger @enderror">
                            <option value="">Pilih Satuan</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('unit')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="is_available" class="block mb-1 text-sm font-medium text-gray-700">Status
                            Ketersediaan<span class="text-danger">* </span></label>
                        <p class="block mb-2 text-xs text-gray-700">Pilih apakah produk bisa dipesan atau tidak oleh
                            pelanggan.</p>
                        <select name="is_available" id="is_available"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 @error('is_available') border-danger @enderror">
                            <option value="" disabled {{ old('is_available') === null ? 'selected' : '' }}>Pilih
                                ketersediaan</option>
                            <option value="Available" {{ old('is_available') === 'Available' ? 'selected' : '' }}>
                                Dijual</option>
                            <option value="Unavailable" {{ old('is_available') === 'Unavailable' ? 'selected' : '' }}>
                                Tidak Dijual</option>
                        </select>
                        @error('is_available')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="harga_modal" class="block mb-2 text-sm font-medium text-gray-700">Harga Modal <span
                                class="text-xs font-normal text-gray-700">(Isi harga modal produk untuk setiap
                                unitnya.)</span></label>
                        <input type="number" name="harga_modal" id="harga_modal" value="{{ old('harga_modal') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 @error('harga_modal') border-danger @enderror"
                            placeholder="20000">
                        @error('harga_modal')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="harga_jual" class="block mb-2 text-sm font-medium text-gray-700">Harga Jual<span
                                class="text-danger">* </span><span class="text-xs font-normal text-gray-700">(Isi harga
                                jual produk untuk setiap
                                unitnya.)</span></label>
                        <input type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 @error('harga_jual') border-danger @enderror"
                            placeholder="20000">
                        @error('harga_jual')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="is_stock_real" class="block mb-1 text-sm font-medium text-gray-700">Status
                            Stok<span class="text-danger">* </span></label>
                        <p class="block mb-2 text-xs text-gray-700">Pilih apakah stok awal sudah sesuai dengan kondisi
                            nyata.</p>
                        <select name="is_stock_real" id="is_stock_real"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 @error('is_stock_real') border-danger @enderror">
                            <option value="" disabled {{ old('is_stock_real') === null ? 'selected' : '' }}>
                                Pilih ketersediaan</option>
                            <option value="true" {{ old('is_stock_real') === 'true' ? 'selected' : '' }}>Sesuai
                            </option>
                            <option value="false" {{ old('is_stock_real') === 'false' ? 'selected' : '' }}>Tidak
                                Sesuai</option>
                        </select>
                        @error('is_stock_real')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="is_modal_real" class="block mb-1 text-sm font-medium text-gray-700">Status Harga
                            Modal<span class="text-danger">* </span></label>
                        <p class="block mb-2 text-xs text-gray-700">Pilih apakah harga modal sudah sesuai dengan
                            kondisi
                            nyata.</p>
                        <select name="is_modal_real" id="is_modal_real"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 @error('is_modal_real') border-danger @enderror">
                            <option value="" disabled {{ old('is_modal_real') === null ? 'selected' : '' }}>
                                Pilih ketersediaan</option>
                            <option value="true" {{ old('is_modal_real') === 'true' ? 'selected' : '' }}>Sesuai
                            </option>
                            <option value="false" {{ old('is_modal_real') === 'false' ? 'selected' : '' }}>Tidak
                                Sesuai</option>
                        </select>
                        @error('is_modal_real')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="my-4">
                    <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-700">Deskripsi
                        Produk<span class="text-danger">* </span></label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 @error('deskripsi') border-danger @enderror"
                        placeholder="Mampu menarik air hingga mengalir sampai jauh...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2 mb-6">
                    <label for="barcode" class="block mb-2 text-sm font-medium text-gray-700">Barcode Produk
                        (Opsional)</label>
                    <p class="block mb-2 text-xs text-gray-700">Pastikan barcode yang diinputkan sudah benar!</p>
                    <div class="flex gap-2">
                        <input type="text" name="barcode" id="barcode" value="{{ old('barcode') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 @error('barcode') border-danger @enderror"
                            placeholder="Masukkan barcode">
                        <button type="button" onclick="openModal('scanner-add')"
                            class="text-white bg-primary border border-primary hover:text-primary hover:bg-white font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                            <span class="ml-2">Scan</span>
                        </button>
                        <x-scanner id="scanner-add"/>
                    </div>
                    @error('barcode')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Foto Produk</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4" id="previewContainer">
                        <label for="imageInput"
                            class="flex items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50">
                            <div class="text-center">
                                <div class="text-3xl text-primary">+</div>
                                <p class="text-sm text-gray-500 mt-1">Tambah Gambar</p>
                            </div>
                        </label>

                    </div>
                    <p class="mt-2 text-xs text-gray-500">PNG, JPG, or JPEG (Max 2MB)</p>

                    <input type="file" id="imageInput" accept="image/png, image/jpeg, image/jpg, image/webp"
                        class="hidden">
                    <input type="hidden" name="images_json" id="imagesJsonInput">
                </div>


                <div class="flex justify-end">
                    <button id="submitBtn" type="submit"
                        class="text-white bg-primary border border-primary hover:bg-white hover:text-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                        <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Tambah Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            openModal('add-produk');
        });
    </script>
@endif
