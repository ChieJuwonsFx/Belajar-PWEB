<div id="add-employee" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" 
         onclick="closeModal('add-employee')"></div>

    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold">Tambah Karyawan Baru</h2>
                    <p class="text-primary-100">Isi Semua Form di Bawah Ini</p>
                </div>
                <button type="button" class="text-white hover:text-primary-100 transition-colors" onclick="closeModal('add-employee')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <form id="add-employee-form" action="{{ route('owner.employee.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="Richie Olajuwon Santoso" required>
                    </div>
                        
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="richieolajuwons@gmail.com" required>
                    </div>
                        
                    <div>
                        <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-700">No Telp</label>
                        <input type="tel" name="no_hp" id="no_hp" pattern="[0-9]{10,15}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="081238038207" required>
                    </div>

                    <div>
                        <label for="role" class="block mb-2 text-sm font-medium text-gray-700">Role</label>
                        <select name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="Kasir">Kasir</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="••••••••" required>
                    </div>
                    
                    <div>
                        <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="mb-6 bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Alamat</h3>
                    <div class="grid gap-4 sm:grid-cols-1 lg:grid-cols-2">
                        <div>
                            <label for="provinsi" class="block mb-2 text-sm font-medium text-gray-700">Provinsi</label>
                            <select id="provinsi" name="provinsi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                                <option value="" selected disabled>Pilih Provinsi</option>
                            </select>
                        </div>
                        <div>
                            <label for="kabupaten" class="block mb-2 text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                            <select id="kabupaten" name="kabupaten" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" disabled required>
                                <option value="" selected disabled>Pilih Provinsi Dulu</option>
                            </select>
                        </div>
                        <div>
                            <label for="kecamatan" class="block mb-2 text-sm font-medium text-gray-700">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" disabled required>
                                <option value="" selected disabled>Pilih Kabupaten Dulu</option>
                            </select>
                        </div>
                        <div>
                            <label for="desa" class="block mb-2 text-sm font-medium text-gray-700">Desa</label>
                            <select id="desa" name="desa" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" disabled required>
                                <option value="" selected disabled>Pilih Kecamatan Dulu</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="alamat" class="block mb-2 text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="3" 
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Jl. Penggangsaan Timur No. 123, RT 001, RW 002" required></textarea>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Foto Profil</label>
                    <div id="profilePreviewContainer">
                        <label id="addImage" for="image"
                            class="flex items-center justify-center w-40 h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                            <div class="text-center">
                                <div class="text-3xl text-primary">+</div>
                                <p class="text-sm text-gray-500 mt-1">Tambah Gambar</p>
                            </div>
                        </label>
                    </div>
                    <p class="mt-3 text-xs text-gray-500">PNG, JPG, or JPEG (Max 2MB)</p>
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/jpg, image/webp" class="hidden">
                </div>

                <div class="flex justify-end">
                    <button id="submitBtn" type="submit" 
                        class="text-white bg-primary border border-primary hover:bg-white hover:text-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                        <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Tambah Karyawan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const profileInput = document.getElementById('image');
    const previewContainer = document.getElementById('profilePreviewContainer');
    const addImage = document.getElementById('addImage');

    profileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert("File harus berupa gambar (jpg, jpeg, png, webp)");
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert("Ukuran maksimal 2MB");
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const base64 = e.target.result;

            const oldPreview = previewContainer.querySelector('.preview-card');
            if (oldPreview) oldPreview.remove();

            addImage.classList.add('hidden');

            const card = document.createElement('div');
            card.className = "relative rounded-lg overflow-hidden w-40 h-40 shadow-md group preview-card";

            card.innerHTML = `
                <img src="${base64}" class="w-40 h-40 object-cover">
                <button type="button" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 hover:bg-red-700 transition"
                        onclick="removeProfileImage()">
                    &times;
                </button>
            `;

            previewContainer.insertBefore(card, addImage);
        };

        reader.readAsDataURL(file);
    });

    function removeProfileImage() {
        const card = previewContainer.querySelector('.preview-card');
        if (card) card.remove();
        profileInput.value = '';

        addImage.classList.remove('hidden');
    }
</script>
