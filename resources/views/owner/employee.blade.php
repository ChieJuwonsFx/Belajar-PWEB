<x-owner>
    <div class="grid mb-6 lg:mb-6 md:grid-cols-2">
        @if (count($users) > 0)
            @foreach ($users as $user)
                <div class="text-primary p-2 relative">
                    <div class="w-full max-w-6xl mx-auto">
                        <div class="bg-white rounded-lg shadow p-4 mb-2 flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                @if ($user->image && Str::startsWith($user->image, 'http'))
                                    <img src="{{ $user->image }}" class="w-16 h-16 object-cover rounded-full shadow"
                                        alt="{{ $user->name }}">
                                @elseif($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}"
                                        class="w-16 h-16 object-cover rounded-full shadow" alt="{{ $user->name }}">
                                @endif
                                {{-- <img src="{{ asset('storage/' . $user->image) }}" class="w-16 h-16 object-cover rounded-full shadow" alt="{{ $user->name }}"> --}}
                                <div>
                                    <h2 class="text-lg font-bold mb-1">{{ $user->name }}</h2>
                                    <p class="text-sm text-secondary">{{ $user->role }}</p>
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
                                    class="hidden absolute top-10 right-0 z-40 bg-white rounded-lg shadow-lg p-4 w-72 transition-all duration-300 user-dropdown">
                                    <div class="text-sm text-primary space-y-3 mb-4">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M2.038 5.61A2.01 2.01 0 0 0 2 6v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6c0-.12-.01-.238-.03-.352l-.866.65-7.89 6.032a2 2 0 0 1-2.429 0L2.884 6.288l-.846-.677Z" />
                                                <path
                                                    d="M20.677 4.117A1.996 1.996 0 0 0 20 4H4c-.225 0-.44.037-.642.105l.758.607L12 10.742 19.9 4.7l.777-.583Z" />
                                            </svg>

                                            <span>{{ $user->email }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span>{{ $user->alamat }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M6.97825 3.99999c-.3729 0-.74128.08169-1.07926.23934-.32394.15109-.61243.36845-.84696.63786-1.81892 1.82189-2.35302 3.87423-1.89899 5.93671.43916 1.9949 1.77747 3.8929 3.45642 5.572 1.67897 1.6791 3.57614 3.0176 5.57034 3.4591 2.0612.4563 4.1141-.0726 5.9396-1.8853.2705-.2348.4888-.524.6405-.8489.1581-.3387.2401-.7081.2401-1.0819 0-.3739-.082-.7432-.2401-1.0819-.1516-.3247-.3696-.6137-.6398-.8483l-1.2098-1.2106c-.5043-.5041-1.1879-.7872-1.9007-.7872-.7128 0-1.3968.2835-1.9011.7876l-.6178.6181c-.1512.1513-.3563.2363-.5701.2363-.2138 0-.4189-.085-.5701-.2363l-1.85336-1.8545c-.15117-.1513-.23609-.3565-.23609-.5704 0-.214.08493-.4192.23613-.5705l.61812-.61851c.5037-.50461.7867-1.18868.7867-1.90191s-.2833-1.39767-.7871-1.90228L8.90499 4.8778c-.23462-.26969-.5233-.48727-.84749-.63847-.33798-.15765-.70636-.23934-1.07925-.23934Z" />
                                                <path fill-rule="evenodd"
                                                    d="M18.0299 8.98132c0 .55229-.4477 1-1 .99999l-3.03-.00002c-.5522 0-1-.44772-1-1V5.99995c0-.55229.4478-1 1-1 .5523 0 1 .44771 1 1v.58112l3.3184-3.29111c.3921-.38892 1.0253-.38631 1.4142.00582.3889.39213.3863 1.02529-.0058 1.4142l-3.2984 3.27133h.6016c.5523.00001 1 .44773 1 1.00001Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span>{{ $user->telp }}</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-3">
                                        <button id="editModalButton" data-modal-target="editModal"
                                            data-modal-toggle="editModal"
                                            class="px-4 py-2 bg-primary text-white border border-primary hover:text-primary hover:bg-white rounded-lg">
                                            Edit Role
                                        </button>
                                        <a href="{{ route('employee.delete', $user->id) }}"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-primary bg-white border border-primary hover:bg-primary hover:text-white rounded-lg">
                                            Fire
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

    </div>



    <div class="flex justify-center m-5">
        <button id="defaultModalButton" data-modal-target="defaultModal" data-modal-toggle="defaultModal"
            class="fixed bottom-6 right-6 bg-white text-primary border-2 border-primary hover:bg-primary hover:text-white w-14 h-14 flex items-center justify-center rounded-full shadow-lg z-40"
            type="button">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    </div>

    <div id="defaultModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full mt-6">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow sm:p-5">
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5">
                    <h3 class="text-lg font-semibold text-gray-900">Add Employee</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="defaultModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('employee.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Enter employee name" required>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" id="email"
                                class="peer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Enter employee email" required>
                        </div>
                        <div>
                            <label for="telp" class="block mb-2 text-sm font-medium text-gray-900">No Telp</label>
                            <input type="tel" name="telp" id="telp" pattern="[0-9]{10,15}"
                                class="peer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Enter employee no telp" required>
                        </div>
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                            <select name="role" id="role"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                required>
                                <option value="" disabled selected>Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Kasir">Kasir</option>
                            </select>
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input type="password" name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Enter password" required>
                        </div>
                        <div>
                            <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900">Confirm
                                Password</label>
                            <input type="password" name="confirm_password" id="confirm_password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Confirm password" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="2"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Masukkan alamat karyawan" required></textarea>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Foto
                            Profile</label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-1.5">
                        <p class="mt-1 text-xs mb-3 text-gray-500">PNG, JPG atau JPEG</p>
                    </div>
                    <button
                        class="text-white inline-flex items-center bg-primary hover:bg-white hover:text-primary border border-primary hover:border-primary focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-1.5 text-center">
                        <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Add new employee
                    </button>
                </form>
            </div>
        </div>
    </div>


    <div id="editModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full mt-6">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow sm:p-5">
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Employee</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="editModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('employee.update', $user->id) }}">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" disabled
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" disabled
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                        <div>
                            <label for="telp" class="block mb-2 text-sm font-medium text-gray-900">No Telp</label>
                            <input type="tel" name="telp" pattern="[0-9]{10,15}" value="{{ $user->telp }}"
                                disabled
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                            <select name="role"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                required>
                                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Kasir" {{ $user->role == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                            <textarea name="alamat" rows="2" disabled
                                class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 p-2.5">{{ $user->alamat }}</textarea>
                        </div>
                    </div>
                    <button
                        class="mt-4 text-white inline-flex items-center bg-primary hover:bg-white hover:text-primary border border-primary hover:border-primary focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-1.5 text-center">
                        <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M17.707 4.293a1 1 0 010 1.414L9.414 14H7v-2.414l8.293-8.293a1 1 0 011.414 0zM5 18a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>
                        Update Employee
                    </button>
                </form>
                @endif

            </div>
        </div>
    </div>




    <script>
        function toggleDropdown(id) {
            const allDropdowns = document.querySelectorAll('.user-dropdown');
            allDropdowns.forEach(dropdown => {
                if (dropdown.id !== id) {
                    dropdown.classList.add('hidden');
                }
            });

            const targetDropdown = document.getElementById(id);
            if (targetDropdown) {
                targetDropdown.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(event) {
            const isInsideDropdownBtn = event.target.closest('button[onclick^="toggleDropdown"]');
            const isInsideDropdown = event.target.closest('.user-dropdown');

            if (!isInsideDropdownBtn && !isInsideDropdown) {
                const allDropdowns = document.querySelectorAll('.user-dropdown');
                allDropdowns.forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            }
        });





        document.addEventListener("DOMContentLoaded", () => {
            const form = document.querySelector("form");
            const telp = document.getElementById("telp");
            const email = document.getElementById("email");
            const password = document.getElementById("password");
            const confirmPassword = document.getElementById("confirm_password");

            // Buat span error di bawah input jika belum ada
            const addErrorText = (input, message) => {
                let error = input.nextElementSibling;
                if (!error || !error.classList.contains('error-message')) {
                    error = document.createElement("p");
                    error.classList.add("text-sm", "text-red-600", "mt-1", "error-message");
                    input.insertAdjacentElement("afterend", error);
                }
                error.innerText = message;
                error.style.display = "block";
            };

            const hideError = (input) => {
                const error = input.nextElementSibling;
                if (error && error.classList.contains("error-message")) {
                    error.style.display = "none";
                }
            };

            // Telp Validation
            telp.addEventListener("input", () => {
                const value = telp.value;
                if (!/^\d{10,15}$/.test(value)) {
                    addErrorText(telp, "No Telp harus angka (10–15 digit)");
                } else {
                    hideError(telp);
                }
            });

            // Email Validation
            email.addEventListener("input", () => {
                const value = email.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    addErrorText(email, "Format email tidak valid");
                } else {
                    hideError(email);
                }
            });

            // Password Matching
            confirmPassword.addEventListener("input", () => {
                if (confirmPassword.value !== password.value) {
                    addErrorText(confirmPassword, "Konfirmasi password tidak sama");
                } else {
                    hideError(confirmPassword);
                }
            });

            // Final Check on Submit
            form.addEventListener("submit", (e) => {
                let valid = true;

                // Cek semua required input
                form.querySelectorAll("input, textarea, select").forEach(input => {
                    if (!input.value.trim()) {
                        addErrorText(input, "Field ini wajib diisi");
                        valid = false;
                    }
                });

                // Cek No Telp
                if (!/^\d{10,15}$/.test(telp.value)) {
                    addErrorText(telp, "No Telp harus angka (10–15 digit)");
                    valid = false;
                }

                // Cek Email
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                    addErrorText(email, "Format email tidak valid");
                    valid = false;
                }

                // Cek Password Confirm
                if (confirmPassword.value !== password.value) {
                    addErrorText(confirmPassword, "Konfirmasi password tidak sama");
                    valid = false;
                }

                if (!valid) {
                    e.preventDefault(); // stop submit
                }
            });
        });
    </script>
</x-owner>
