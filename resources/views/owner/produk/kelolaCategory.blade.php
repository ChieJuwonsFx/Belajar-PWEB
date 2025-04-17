<div id="kelola-kategori" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
         onclick="closeModal('kelola-kategori')"></div>

    <div class="relative bg-white rounded-xl shadow-2xl max-w-3xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Kelola Kategori</h2>
                <button type="button"
                        class="text-white hover:text-primary-100 transition-colors"
                        onclick="closeModal('kelola-kategori')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6 space-y-4">
            <form method="POST" action="{{ route('owner.kategori.create') }}" class="flex gap-2">
                @csrf
                <input type="text" name="nama" placeholder="Nama Kategori"
                       class="flex-1 py-2 px-3 border rounded-lg text-sm focus:ring-1 focus:border-primary focus:ring-primary" required>
                <button type="submit"
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                    Tambah
                </button>
            </form>

            <div class="max-h-96 overflow-y-auto">
                <ul>
                    @foreach($categories as $category)
                        <li class="flex gap-2 justify-between items-center py-2">
                            <form method="POST" action="{{ route('owner.kategori.update', $category->id) }}" class="flex flex-1 gap-2 items-center">
                                @csrf
                                @method('PUT')
                                <input type="text" name="nama" value="{{ $category->name }}"
                                       class="flex-1 py-1.5 px-2 border rounded text-sm focus:ring-1 focus:border-primary focus:ring-primary">
                                <button type="submit" 
                                    class="h-9 w-20 text-sm bg-primary text-white border border-primary hover:text-primary hover:bg-white rounded-lg whitespace-nowrap">
                                    Simpan
                                </button>
                            </form>
                            <button onclick="openModal('delete-konfirmasi-{{ $category->id }}')" 
                                class="h-9 w-28 text-sm bg-primary text-white border border-primary hover:text-primary hover:bg-white rounded-lg whitespace-nowrap">
                                Hapus
                            </button>
                            <x-danger-modal
                                id="delete-konfirmasi-{{ $category->id }}"
                                title="Peringatan!"
                                message="Apakah kamu yakin ingin menghapus kategori :name ini? Tindakan ini tidak dapat dibatalkan."
                                :route="route('owner.kategori.delete', $category->id)"
                                name="{{ $category->name }}"
                                buttonText="Ya, Hapus"
                                cancelText="Batal"
                            />
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 text-right border-t">
            <button type="button"
                    onclick="closeModal('kelola-kategori')"
                    class="px-4 py-2 text-sm bg-white border border-primary text-primary rounded-lg hover:bg-gray-100">
                Tutup
            </button>
        </div>
    </div>
</div>
