<x-kasir>
    <div class="min-h-screen">
        <main class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-8">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="relative bg-primary px-8 py-12">
                            <div class="absolute inset-0"></div>
                            <div class="relative flex items-center space-x-6">
                                <div class="relative">
                                    @if ($user->image && Str::startsWith($user->image, 'http'))
                                        <img src="{{ $user->image }}"
                                            class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover"
                                            alt="{{ $user->name }}">
                                    @elseif($user->image)
                                        <img src="{{ asset('storage/' . $user->image) }}"
                                            class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover"
                                            alt="{{ $user->name }}">
                                    @else
                                        <div
                                            class="w-24 h-24 rounded-full border-4 border-white shadow-lg bg-gray-300 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-500" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div
                                        class="absolute -bottom-2 -right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                                        {{ $user->role }}
                                    </div>
                                </div>
                                <div class="text-white">
                                    <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                                    <p class="text-blue-100 text-lg">{{ $user->email }}</p>
                                    @if ($user->no_hp)
                                        <p class="text-blue-100 flex items-center mt-2">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                                </path>
                                            </svg>
                                            {{ $user->no_hp }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-gray-50 to-white p-6 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Informasi Profil</h3>
                                        <p class="text-gray-600">Perbarui informasi dan detail profil akun Anda.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8">
                                <form method="post" action="{{ route('kasir.profile.update') }}"
                                    enctype="multipart/form-data" class="space-y-8">
                                    @csrf
                                    @method('patch')

                                    <div class="flex items-center space-x-6">
                                        <div class="relative">
                                            @if ($user->image && Str::startsWith($user->image, 'http'))
                                                <img id="profileImagePreview" src="{{ $user->image }}"
                                                    class="w-20 h-20 rounded-full object-cover border-4 border-gray-200"
                                                    alt="{{ $user->name }}">
                                            @elseif($user->image)
                                                <img id="profileImagePreview"
                                                    src="{{ asset('storage/' . $user->image) }}"
                                                    class="w-20 h-20 rounded-full object-cover border-4 border-gray-200"
                                                    alt="{{ $user->name }}">
                                            @else
                                                <div id="profileImagePreview"
                                                    class="w-20 h-20 rounded-full border-4 border-gray-200 bg-gray-100 flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-gray-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <label for="image"
                                                class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                Ganti Foto
                                            </label>
                                            <input type="file" id="image" name="image" accept="image/*"
                                                class="hidden">
                                            <p class="text-xs text-gray-500 mt-2">JPG, PNG, atau WEBP (Maks 2MB)</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="name"
                                                class="block text-sm font-semibold text-gray-700 mb-2">Nama
                                                Lengkap</label>
                                            <input id="name" name="name" type="text"
                                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                                value="{{ old('name', $user->name) }}" required autofocus>
                                            @error('name')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="no_hp"
                                                class="block text-sm font-semibold text-gray-700 mb-2">Nomor
                                                Telepon</label>
                                            <input id="no_hp" name="no_hp" type="tel"
                                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                                value="{{ old('no_hp', $user->no_hp) }}" placeholder="081234567890">
                                            @error('no_hp')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 rounded-xl p-6 space-y-6">
                                        <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            Informasi Alamat
                                        </h4>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="provinsi"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                                                <select id="provinsi" name="provinsi"
                                                    class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                                    <option value="">Pilih Provinsi</option>
                                                    @if ($user->village)
                                                        <option
                                                            value="{{ $user->village->district->city->province->id_provinsi }}"
                                                            selected>
                                                            {{ $user->village->district->city->province->nama_provinsi }}
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div>
                                                <label for="kabupaten"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Kabupaten/Kota</label>
                                                <select id="kabupaten" name="kabupaten"
                                                    class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                                    {{ !$user->village ? 'disabled' : '' }}>
                                                    <option value="">Pilih Kabupaten/Kota</option>
                                                    @if ($user->village)
                                                        <option
                                                            value="{{ $user->village->district->city->id_kabupaten }}"
                                                            selected>
                                                            {{ $user->village->district->city->nama_kabupaten }}
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div>
                                                <label for="kecamatan"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                                                <select id="kecamatan" name="kecamatan"
                                                    class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                                    {{ !$user->village ? 'disabled' : '' }}>
                                                    <option value="">Pilih Kecamatan</option>
                                                    @if ($user->village)
                                                        <option value="{{ $user->village->district->id_kecamatan }}"
                                                            selected>
                                                            {{ $user->village->district->nama_kecamatan }}
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div>
                                                <label for="desa"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Desa/Kelurahan</label>
                                                <select id="desa" name="desa"
                                                    class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                                    {{ !$user->village ? 'disabled' : '' }}>
                                                    <option value="">Pilih Desa/Kelurahan</option>
                                                    @if ($user->village)
                                                        <option value="{{ $user->village->id_desa }}" selected>
                                                            {{ $user->village->nama_desa }}
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="alamat"
                                                class="block text-sm font-medium text-gray-700 mb-2">Alamat
                                                Lengkap</label>
                                            <textarea id="alamat" name="alamat" rows="3"
                                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                                placeholder="Masukkan alamat lengkap Anda (jalan, RT/RW, dll)">{{ old('alamat', $user->alamat) }}</textarea>
                                            @error('alamat')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-6">
                                        <div class="flex items-center space-x-4">
                                            @if (session('status') === 'profile-updated')
                                                <div x-data="{ show: true }" x-show="show" x-transition
                                                    x-init="setTimeout(() => show = false, 3000)"
                                                    class="flex items-center space-x-2 text-green-600 bg-green-50 px-4 py-2 rounded-lg">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="font-medium">Profil berhasil diperbarui!</span>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="submit"
                                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wider hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mt-8">
                            <div class="bg-gradient-to-r from-gray-50 to-white p-6 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Perbarui Password</h3>
                                        <p class="text-gray-600">Pastikan akun Anda menggunakan password yang kuat.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8">
                                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                                    @csrf
                                    @method('put')

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="current_password"
                                                class="block text-sm font-medium text-gray-700 mb-2">Password Saat
                                                Ini</label>
                                            <input id="current_password" name="current_password" type="password"
                                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                                required autocomplete="current-password"
                                                placeholder="Masukkan password saat ini">
                                            @error('current_password')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="password"
                                                class="block text-sm font-medium text-gray-700 mb-2">Password
                                                Baru</label>
                                            <input id="password" name="password" type="password"
                                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                                required autocomplete="new-password"
                                                placeholder="Masukkan password baru">
                                            @error('password')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="password_confirmation"
                                                class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi
                                                Password</label>
                                            <input id="password_confirmation" name="password_confirmation"
                                                type="password"
                                                class="block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                                required autocomplete="new-password"
                                                placeholder="Konfirmasi password baru">
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-4">
                                        <div class="flex items-center space-x-4">
                                            @if (session('status') === 'password-updated')
                                                <div x-data="{ show: true }" x-show="show" x-transition
                                                    x-init="setTimeout(() => show = false, 3000)"
                                                    class="flex items-center space-x-2 text-green-600 bg-green-50 px-4 py-2 rounded-lg">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="font-medium">Password berhasil diperbarui!</span>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="submit"
                                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wider hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Perbarui Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Akun</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">Peran</span>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $user->role }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">Status Akun</span>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">Bergabung Sejak</span>
                                    <span
                                        class="text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between py-3">
                                    <span class="text-sm font-medium text-gray-600">Terakhir Diperbarui</span>
                                    <span
                                        class="text-sm text-gray-900">{{ $user->updated_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        @if ($user->village)
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                    </svg>
                                    Lokasi Saat Ini
                                </h3>
                                <div class="space-y-3 text-sm text-gray-600">
                                    <div class="flex justify-between">
                                        <span class="font-medium">Desa:</span>
                                        <span>{{ $user->village->nama_desa }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Kecamatan:</span>
                                        <span>{{ $user->village->district->nama_kecamatan }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Kota:</span>
                                        <span>{{ $user->village->district->city->nama_kabupaten }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Provinsi:</span>
                                        <span>{{ $user->village->district->city->province->nama_provinsi }}</span>
                                    </div>
                                    @if ($user->alamat)
                                        <div class="pt-2 border-t border-gray-100">
                                            <span class="font-medium">Alamat:</span>
                                            <p class="mt-1 text-gray-900">{{ $user->alamat }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('profileImagePreview');
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.id = 'profileImagePreview';
                        img.src = e.target.result;
                        img.className = 'w-20 h-20 rounded-full object-cover border-4 border-gray-200';
                        img.alt = 'Profile Preview';
                        preview.parentNode.replaceChild(img, preview);
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        const BASE_URL = 'https://chiejuwonsfx.github.io/api-wilayah-indonesia/json';

        const provinsiSelect = document.getElementById('provinsi');
        const kabupatenSelect = document.getElementById('kabupaten');
        const kecamatanSelect = document.getElementById('kecamatan');
        const desaSelect = document.getElementById('desa');

        fetch(`${BASE_URL}/provinces.json`)
            .then(response => response.json())
            .then(data => {
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.id;
                    option.textContent = province.nama;
                    provinsiSelect.appendChild(option);
                });

                @if (
                    $user->village &&
                        $user->village->district &&
                        $user->village->district->city &&
                        $user->village->district->city->province)
                    provinsiSelect.value = '{{ $user->village->district->city->province->id_provinsi }}';
                    provinsiSelect.dispatchEvent(new Event('change'));
                @endif
            })
            .catch(error => console.error('Error loading provinces:', error));

        provinsiSelect.addEventListener('change', function() {
            const provinsiId = this.value;

            kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';

            kabupatenSelect.disabled = !provinsiId;
            kecamatanSelect.disabled = true;
            desaSelect.disabled = true;

            if (provinsiId) {
                fetch(`${BASE_URL}/regencies/${provinsiId}.json`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(regency => {
                            const option = document.createElement('option');
                            option.value = regency.id;
                            option.textContent = regency.nama;
                            kabupatenSelect.appendChild(option);
                        });

                        @if ($user->village && $user->village->district && $user->village->district->city)
                            kabupatenSelect.value = '{{ $user->village->district->city->id_kabupaten }}';
                            kabupatenSelect.dispatchEvent(new Event('change'));
                        @endif
                    })
                    .catch(error => console.error('Error loading regencies:', error));
            }
        });

        kabupatenSelect.addEventListener('change', function() {
            const kabupatenId = this.value;

            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';

            kecamatanSelect.disabled = !kabupatenId;
            desaSelect.disabled = true;

            if (kabupatenId) {
                fetch(`${BASE_URL}/districts/${kabupatenId}.json`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(district => {
                            const option = document.createElement('option');
                            option.value = district.id;
                            option.textContent = district.nama;
                            kecamatanSelect.appendChild(option);
                        });

                        @if ($user->village && $user->village->district)
                            kecamatanSelect.value = '{{ $user->village->district->id_kecamatan }}';
                            kecamatanSelect.dispatchEvent(new Event('change'));
                        @endif
                    })
                    .catch(error => console.error('Error loading districts:', error));
            }
        });

        kecamatanSelect.addEventListener('change', function() {
            const kecamatanId = this.value;

            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
            desaSelect.disabled = !kecamatanId;

            if (kecamatanId) {
                fetch(`${BASE_URL}/villages/${kecamatanId}.json`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(village => {
                            const option = document.createElement('option');
                            option.value = village.id;
                            option.textContent = village.nama;
                            desaSelect.appendChild(option);
                        });

                        @if ($user->village)
                            desaSelect.value = '{{ $user->village->id_desa }}';
                        @endif
                    })
                    .catch(error => console.error('Error loading villages:', error));
            }
        });
    </script>
</x-kasir>
