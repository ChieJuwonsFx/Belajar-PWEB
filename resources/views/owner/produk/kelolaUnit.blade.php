<x-owner>
    <div class=" px-4 py-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                    </svg>
                    Kelola Unit
                </h1>
                <p class="text-sm text-gray-500 mt-1">Manajemen satuan unit produk</p>
            </div>
        </div>

        <div class="mb-8 p-5 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-800">Tambah Unit Baru</h2>
            </div>
            
            <form method="POST" action="{{ route('owner.unit.store') }}" class="flex flex-col md:flex-row gap-4 items-end">
                @csrf
                <div class="flex-1 w-full">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Unit</label>
                    <input type="text" name="nama" id="nama" placeholder="Contoh: Kilogram"
                        class="w-full py-2.5 px-3 border border-gray-300 rounded-lg text-sm transition">
                </div>
                <div class="w-full md:w-48">
                    <label for="singkatan" class="block text-sm font-medium text-gray-700 mb-1">Singkatan</label>
                    <input type="text" name="singkatan" id="singkatan" placeholder="Contoh: kg"
                        class="w-full py-2.5 px-3 border border-gray-300 rounded-lg text-sm transition">
                </div>
                <div>
                    <button type="submit"
                        class="px-4 py-2.5 text-sm bg-primary text-white border border-primary rounded-lg hover:bg-white hover:text-primary transition flex items-center whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Unit
                    </button>
                </div>
            </form>
        </div>

        <!-- Units List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center px-5 py-4 bg-gray-50 border-b border-gray-200">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-800">Daftar Unit</h2>
            </div>
            
            <ul class="divide-y divide-gray-200">
                @foreach ($units as $unit)
                    <li class="p-5 hover:bg-gray-50 transition-colors">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <form method="POST" action="{{ route('owner.unit.update', $unit->id) }}"
                                class="w-full flex flex-col sm:flex-row sm:items-center gap-3">
                                @csrf
                                @method('PUT')
                            
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 flex-1 w-full">
                                    <div class="flex-1">
                                        <input type="text" name="nama" value="{{ $unit->name }}"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg text-sm transition">
                                    </div>
                                    <div class="w-full sm:w-48">
                                        <input type="text" name="singkatan" value="{{ $unit->singkatan }}"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-lg text-sm transition">
                                    </div>
                                </div>
                            
                                <div class="flex gap-2">
                                    <button type="submit"
                                        class="px-3 py-2 bg-primary text-white border border-primary rounded-lg hover:bg-white hover:text-primary transition flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Simpan
                                    </button>
                                    <button onclick="openModal('delete-konfirmasi-{{ $unit->id }}')" type="button"
                                        class="px-3 py-2 bg-danger text-white border border-danger rounded-lg hover:bg-white hover:text-danger transition flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </form>
                            
                            <x-danger-modal
                                id="delete-konfirmasi-{{ $unit->id }}"
                                title="Peringatan!"
                                message="Apakah kamu yakin ingin menghapus unit :name ini? Tindakan ini tidak dapat dibatalkan."
                                :route="route('owner.unit.delete', $unit->id)"
                                name="{{ $unit->name }}"
                                buttonText="Ya, Hapus"
                                cancelText="Batal"
                            />
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-owner>