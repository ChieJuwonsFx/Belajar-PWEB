<x-owner>
    <div class="mx-auto px-4 p-6 w-full">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Kelola Kategori</h1>
        </div>

        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h2 class="text-lg font-medium mb-4">Tambah Kategori Baru</h2>
            <form method="POST" action="{{ route('owner.kategori.store') }}" class="flex flex-col md:flex-row gap-4">
                @csrf
                <div class="flex-1">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="nama" id="nama" placeholder="Contoh: Elektronik"
                        class="w-full py-2 px-3 border rounded-lg focus:ring-primary focus:border-primary text-sm" required>
                </div>
                <div class="self-end">
                    <button type="submit"
                        class="px-4 py-2 bg-primary text-white border border-primary rounded-lg hover:bg-white hover:text-primary transition text-sm">
                        Tambah Kategori
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <h2 class="text-lg font-medium p-4 bg-gray-50">Daftar Kategori</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($categories as $category)
                    <li class="p-4 hover:bg-gray-50">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
                            <form method="POST" action="{{ route('owner.kategori.update', $category->id) }}"
                                class="w-full flex flex-col md:flex-row md:items-center md:gap-4">
                                @csrf
                                @method('PUT')
                            
                                <div class="flex-1 mb-2 md:mb-0">
                                    <input type="text" name="nama" value="{{ $category->name }}"
                                        class="w-full py-1.5 px-3 border rounded focus:ring-primary focus:border-primary text-sm">
                                </div>
                            
                                <div class="flex gap-2 mt-2 md:mt-0">
                                    <button type="submit"
                                        class="px-3 py-1.5 bg-primary text-white border border-primary hover:text-primary hover:bg-white rounded-md text-sm">
                                        Simpan
                                    </button>
                                    <button onclick="openModal('delete-konfirmasi-{{ $category->id }}')" type="button"
                                        class="px-3 py-1.5 bg-danger text-white border border-danger hover:text-danger hover:bg-white rounded-md text-sm">
                                        Hapus
                                    </button>
                                </div>
                            </form>
                            
                            <x-danger-modal
                                id="delete-konfirmasi-{{ $category->id }}"
                                title="Peringatan!"
                                message="Apakah kamu yakin ingin menghapus category :name ini? Tindakan ini tidak dapat dibatalkan."
                                :route="route('owner.kategori.delete', $category->id)"
                                name="{{ $category->name }}"
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
