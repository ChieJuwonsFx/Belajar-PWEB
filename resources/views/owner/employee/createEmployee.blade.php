<div id="add-employee" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" 
         onclick="closeModal('add-employee')"></div>

    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold">Add New Employee</h2>
                    <p class="text-primary-100">Fill all required fields</p>
                </div>
                <button type="button" 
                        class="text-white hover:text-primary-100 transition-colors"
                        onclick="closeModal('add-employee')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <form id="alamatForm" action="{{ route('employee.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                placeholder="John Doe" required>
                        </div>
                        
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                placeholder="john.doe@company.com" required>
                        </div>
                        
                        <div>
                            <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="no_hp" id="no_hp" pattern="[0-9]{10,15}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                placeholder="081234567890" required>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-700">Role</label>
                            <select name="role" id="role"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                required>
                                <option value="" disabled selected>Select Role</option>
                                <option value="Kasir">Kasir</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                placeholder="••••••••" required>
                        </div>
                        
                        <div>
                            <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                placeholder="••••••••" required>
                        </div>
                    </div>
                </div>

                <div class="mb-6 bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Region Information</h3>
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label for="provinsi" class="block mb-2 text-sm font-medium text-gray-700">Province</label>
                            <select id="provinsi" name="provinsi"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                required>
                                <option value="" selected disabled>Select Province</option>
                            </select>
                        </div>
                        <div>
                            <label for="kabupaten" class="block mb-2 text-sm font-medium text-gray-700">Regency/City</label>
                            <select id="kabupaten" name="kabupaten"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                disabled required>
                                <option value="" selected disabled>Select Province First</option>
                            </select>
                        </div>
                        <div>
                            <label for="kecamatan" class="block mb-2 text-sm font-medium text-gray-700">District</label>
                            <select id="kecamatan" name="kecamatan"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                disabled required>
                                <option value="" selected disabled>Select Regency First</option>
                            </select>
                        </div>
                        <div>
                            <label for="desa" class="block mb-2 text-sm font-medium text-gray-700">Village</label>
                            <select id="desa" name="desa"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                disabled required>
                                <option value="" selected disabled>Select District First</option>
                            </select>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="provinsi_id" id="provinsi_id">
                <input type="hidden" name="provinsi_nama" id="provinsi_nama">

                <input type="hidden" name="kabupaten_id" id="kabupaten_id">
                <input type="hidden" name="kabupaten_nama" id="kabupaten_nama">

                <input type="hidden" name="kecamatan_id" id="kecamatan_id">
                <input type="hidden" name="kecamatan_nama" id="kecamatan_nama">

                <input type="hidden" name="desa_id" id="desa_id">
                <input type="hidden" name="desa_nama" id="desa_nama">


                <div class="grid gap-6 mb-6">
                    <div>
                        <label for="alamat" class="block mb-2 text-sm font-medium text-gray-700">Complete Address</label>
                        <textarea name="alamat" id="alamat" rows="3"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Jl. Example No. 123, RT/RW 001/002" required></textarea>
                    </div>
                    
                    <div>
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-700">Profile Photo</label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2">
                        <p class="mt-1 text-xs text-gray-500">PNG, JPG, or JPEG (Max 2MB)</p>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button id="submitBtn" type="submit"
                        class="text-white bg-primary hover:bg-primary-dark focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                        <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Add Employee
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const BASE_URL = 'https://chiejuwonsfx.github.io/api-wilayah-indonesia/json';

        const provinsiSelect = document.getElementById('provinsi');
        const kabupatenSelect = document.getElementById('kabupaten');
        const kecamatanSelect = document.getElementById('kecamatan');
        const desaSelect = document.getElementById('desa');

        let provinsiData = {};
        let selectedCityDistricts = [];
        let selectedDistrictVillages = [];

        const populateSelect = (selectElem, items, placeholder) => {
            selectElem.innerHTML = `<option value="">${placeholder}</option>`;
            items.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.id;
                opt.textContent = item.nama;
                selectElem.appendChild(opt);
            });
            selectElem.disabled = false;
        };

        fetch(`${BASE_URL}/provinces.json`)
            .then(res => res.json())
            .then(data => populateSelect(provinsiSelect, data, 'Pilih Provinsi'));

        provinsiSelect.addEventListener('change', function () {
            const provId = this.value;
            if (!provId) return;

            kabupatenSelect.disabled = true;
            kecamatanSelect.disabled = true;
            desaSelect.disabled = true;
            
            fetch(`${BASE_URL}/regencies/${provId}.json`)
                .then(res => res.json())
                .then(data => {
                    populateSelect(kabupatenSelect, data, 'Pilih Kabupaten/Kota');
                });
        });

        kabupatenSelect.addEventListener('change', function () {
            const kabId = this.value;
            if (!kabId) return;

            kecamatanSelect.disabled = true;
            desaSelect.disabled = true;

            fetch(`${BASE_URL}/districts/${kabId}.json`)
                .then(res => res.json())
                .then(data => {
                    populateSelect(kecamatanSelect, data, 'Pilih Kecamatan');
                });
        });

        kecamatanSelect.addEventListener('change', function () {
            const kecId = this.value;
            if (!kecId) return;

            desaSelect.disabled = true;

            fetch(`${BASE_URL}/villages/${kecId}.json`)
                .then(res => res.json())
                .then(data => {
                    populateSelect(desaSelect, data, 'Pilih Desa');
                });
        });



        const getSelectedLocation = () => {
            const provinsiId = provinsiSelect.value;
            const provinsiNama = provinsiSelect.options[provinsiSelect.selectedIndex].textContent;

            const kabupatenId = kabupatenSelect.value;
            const kabupatenNama = kabupatenSelect.options[kabupatenSelect.selectedIndex].textContent;

            const kecamatanId = kecamatanSelect.value;
            const kecamatanNama = kecamatanSelect.options[kecamatanSelect.selectedIndex].textContent;

            const desaId = desaSelect.value;
            const desaNama = desaSelect.options[desaSelect.selectedIndex].textContent;

            return {
                provinsi: { id: provinsiId, nama: provinsiNama },
                kabupaten: { id: kabupatenId, nama: kabupatenNama },
                kecamatan: { id: kecamatanId, nama: kecamatanNama },
                desa: { id: desaId, nama: desaNama }
            };
        };


        document.getElementById('submitBtn').addEventListener('click', () => {
            const lokasi = getSelectedLocation();
            console.log('Data Lokasi Dipilih:', lokasi);

            document.getElementById('provinsi_id').value = lokasi.provinsi.id;
            document.getElementById('provinsi_nama').value = lokasi.provinsi.nama;

            document.getElementById('kabupaten_id').value = lokasi.kabupaten.id;
            document.getElementById('kabupaten_nama').value = lokasi.kabupaten.nama;

            document.getElementById('kecamatan_id').value = lokasi.kecamatan.id;
            document.getElementById('kecamatan_nama').value = lokasi.kecamatan.nama;

            document.getElementById('desa_id').value = lokasi.desa.id;
            document.getElementById('desa_nama').value = lokasi.desa.nama;
        });
    </script>
</div>
