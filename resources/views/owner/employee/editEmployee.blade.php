{{-- <div id="editModal" tabindex="-1" aria-hidden="true"
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
                    <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-900">No HP</label>
                    <input type="tel" name="no_hp" pattern="[0-9]{10,15}" value="{{ $user->no_hp }}"
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
    </div>
</div> --}}


<div id="editModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" 
         onclick="closeModal('editModal')"></div>

    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold">Add New Employee</h2>
                    <p class="text-primary-100">Fill all required fields</p>
                </div>
                <button type="button" 
                        class="text-white hover:text-primary-100 transition-colors"
                        onclick="closeModal('editModal')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <form id="edit-employee-form" action="{{ route('employee.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') 
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" readonly>
                        </div>
                        
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" readonly>
                        </div>
                        

                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-700">Role</label>
                            <select name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                                <option value="" disabled>Select Role</option>
                                <option value="Kasir" {{ $user->role == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div>
                            <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="no_hp" id="no_hp" pattern="[0-9]{10,15}" value="{{ $user->no_hp }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"readonly>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 mb-6">
                    <div>
                        <label for="alamat" class="block mb-2 text-sm font-medium text-gray-700">Complete Address</label>
                        <textarea name="alamat" id="alamat" rows="3"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                            readonly>{{ collect([
                                $user->alamat,
                                $user->village?->nama_desa,
                                $user->village?->district?->nama_kecamatan,
                                $user->village?->district?->city?->nama_kabupaten,
                                $user->village?->district?->city?->province?->nama_provinsi,
                            ])->filter()->implode(', ') }}</textarea>
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


</div>
