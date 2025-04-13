<x-owner>
    <div class="p-6 w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($users as $user)
                <div class="text-primary p-2 relative">
                    <div class="w-full max-w-6xl mx-auto">
                        <div class="bg-white rounded-lg shadow p-4 mb-2 flex justify-between items-center">
                            <div class="grid grid-rows-[auto_auto] gap-1 items-center">                            
                                @if ($user->image && Str::startsWith($user->image, 'http'))
                                    <img src="{{ $user->image }}" class="w-16 h-16 object-cover rounded-full shadow"
                                        alt="{{ $user->name }}">
                                @elseif($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}"
                                        class="w-16 h-16 object-cover rounded-full shadow" alt="{{ $user->name }}">
                                @endif
                                <div class="h-6 w-16 flex items-center justify-center">
                                    <div class="py-1 rounded-lg text-xs font-medium text-center w-full bg-green-100 text-green-800' ">
                                        {{ $user->role }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1 min-w-0 ml-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <h3 class="text-lg font-bold truncate">{{ $user->name }}</h3>
                                    </div>
                                    <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="relative">
                                <button onclick="toggleDropdown('{{ $user->id }}')"
                                    class="text-secondary hover:text-primary hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200 rounded-full p-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="3"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 12h.01M12 12h.01M18 12h.01" />
                                    </svg>
                                </button>

                                <div id="{{ $user->id }}"
                                    class="hidden absolute top-10 right-0 z-40 bg-white rounded-lg shadow-lg p-4 w-72 md:w-80 lg:w-96 transition-all duration-300 user-dropdown">
                                   <div class="text-sm text-primary space-y-3 mb-4">
                                       <div class="flex items-center gap-2">
                                           <div class="flex-shrink-0 pt-0.5">
                                               <svg class="w-5 h-5 text-primary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                   <path d="M2.038 5.61A2.01 2.01 0 0 0 2 6v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6c0-.12-.01-.238-.03-.352l-.866.65-7.89 6.032a2 2 0 0 1-2.429 0L2.884 6.288l-.846-.677Z"/>
                                                   <path d="M20.677 4.117A1.996 1.996 0 0 0 20 4H4c-.225 0-.44.037-.642.105l.758.607L12 10.742 19.9 4.7l.777-.583Z"/>
                                               </svg>
                                           </div>
                                           <span class="break-words">{{ $user->email }}</span>
                                       </div>
                                       <div class="flex items-center gap-2">
                                           <div class="flex-shrink-0 pt-0.5">
                                               <svg class="w-5 h-5 text-primary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                   <path fill-rule="evenodd" d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z" clip-rule="evenodd"/>
                                               </svg>
                                           </div>
                                           <span class="break-words">
                                               {{ collect([
                                                   $user->alamat,
                                                   $user->village?->nama_desa,
                                                   $user->village?->district?->nama_kecamatan,
                                                   $user->village?->district?->city?->nama_kabupaten,
                                                   $user->village?->district?->city?->province?->nama_provinsi,
                                               ])->filter()->implode(', ') }}
                                           </span>
                                       </div>
                                       <div class="flex items-center gap-2">
                                           <svg class="w-5 h-5 text-primary flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                               <path d="M6.97825 3.99999c-.3729 0-.74128.08169-1.07926.23934-.32394.15109-.61243.36845-.84696.63786-1.81892 1.82189-2.35302 3.87423-1.89899 5.93671.43916 1.9949 1.77747 3.8929 3.45642 5.572 1.67897 1.6791 3.57614 3.0176 5.57034 3.4591 2.0612.4563 4.1141-.0726 5.9396-1.8853.2705-.2348.4888-.524.6405-.8489.1581-.3387.2401-.7081.2401-1.0819 0-.3739-.082-.7432-.2401-1.0819-.1516-.3247-.3696-.6137-.6398-.8483l-1.2098-1.2106c-.5043-.5041-1.1879-.7872-1.9007-.7872-.7128 0-1.3968.2835-1.9011.7876l-.6178.6181c-.1512.1513-.3563.2363-.5701.2363-.2138 0-.4189-.085-.5701-.2363l-1.85336-1.8545c-.15117-.1513-.23609-.3565-.23609-.5704 0-.214.08493-.4192.23613-.5705l.61812-.61851c.5037-.50461.7867-1.18868.7867-1.90191s-.2833-1.39767-.7871-1.90228L8.90499 4.8778c-.23462-.26969-.5233-.48727-.84749-.63847-.33798-.15765-.70636-.23934-1.07925-.23934Z"/>
                                               <path fill-rule="evenodd" d="M18.0299 8.98132c0 .55229-.4477 1-1 .99999l-3.03-.00002c-.5522 0-1-.44772-1-1V5.99995c0-.55229.4478-1 1-1 .5523 0 1 .44771 1 1v.58112l3.3184-3.29111c.3921-.38892 1.0253-.38631 1.4142.00582.3889.39213.3863 1.02529-.0058 1.4142l-3.2984 3.27133h.6016c.5523.00001 1 .44773 1 1.00001Z" clip-rule="evenodd"/>
                                           </svg>
                                           <span>{{ $user->no_hp }}</span>
                                       </div>
                                   </div>
                                   
                                   <div class="flex flex-wrap gap-3">
                                       <button onclick="openModal('editModal-{{ $user->id }}')" class="px-4 py-2 bg-primary text-white border border-primary hover:text-primary hover:bg-white rounded-lg whitespace-nowrap">
                                           Edit Role
                                       </button>
                                        <button
                                                class="px-4 py-2 bg-primary text-white border border-primary hover:text-primary hover:bg-white rounded-lg whitespace-nowrap">
                                            Pecat
                                        </button>
                                        <x-danger-modal
                                            id="deleteModal-{{ $user->id }}"
                                            title="Peringatan!"
                                            message="Apakah kamu yakin ingin memecat :name dari perusahaan? Tindakan ini tidak dapat dibatalkan."
                                            :route="route('employee.delete', $user->id)"
                                            name="{{ $user->name }}"
                                            buttonText="Ya, Pecat"
                                            cancelText="Batal"
                                        />
                                   </div>
                               </div>                            
                            </div>
                        </div>
                    </div>
                    @include('owner.employee.editEmployee', ['user' => $user])             

                </div>   
            @endforeach
        </div>
    </div>

    <div class="fixed bottom-6 right-6">
        <button onclick="openModal('add-employee')" 
                class="p-4 bg-primary text-white rounded-full shadow-lg hover:bg-primary-dark transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
        </button>
    </div>

    @include('owner.employee.createEmployee')

    <script>
        function toggleDropdown(id) {
            const allDropdowns = document.querySelectorAll('.user-dropdown');
            allDropdowns.forEach(dropdown => {
                if (dropdown.id !== id) {
                    dropdown.classList.add('hidden');
                }
            });

            const targetDropdown = document.getElementById(id);
            targetDropdown.classList.toggle('hidden');
        }

        function openModal(id) {
            document.getElementById(id)?.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(id) {
            document.getElementById(id)?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.user-dropdown') && !event.target.closest('[onclick^="toggleDropdown"]')) {
                document.querySelectorAll('.user-dropdown').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[id^="edit-user-"], [id^="delete-user-"]').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeModal(this.id);
                    }
                });
            });
        });
    </script>
    <script>
        const BASE_URL = 'https://chiejuwonsfx.github.io/api-wilayah-indonesia/json';

        function initializeLocationSelection(formId) {
            const form = document.getElementById(formId);
            if (!form) return;
            
            const provinsiSelect = form.querySelector('[name="provinsi"]');
            const kabupatenSelect = form.querySelector('[name="kabupaten"]');
            const kecamatanSelect = form.querySelector('[name="kecamatan"]');
            const desaSelect = form.querySelector('[name="desa"]');

            const submitBtn = form.querySelector('[type="submit"]');
            
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
            
            provinsiSelect.addEventListener('change', function() {
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
            
            kabupatenSelect.addEventListener('change', function() {
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
            
            kecamatanSelect.addEventListener('change', function() {
                const kecId = this.value;
                if (!kecId) return;
                
                desaSelect.disabled = true;
                
                fetch(`${BASE_URL}/villages/${kecId}.json`)
                    .then(res => res.json())
                    .then(data => {
                        populateSelect(desaSelect, data, 'Pilih Desa');
                    });
            });
        }
        

        document.addEventListener('DOMContentLoaded', function() {
            initializeLocationSelection('add-employee-form');
            initializeLocationSelection('edit-employee-form');
        });
    </script>
</x-owner>