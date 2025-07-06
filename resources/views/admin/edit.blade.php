<x-layouts.layout :title="$title" :active="$active">
    <main class="flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
        <div
            class="bg-white w-full max-w-5xl py-4 sm:py-6 lg:py-9 px-4 sm:px-6 lg:px-12 rounded-xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Profile Section -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6">
                    <div id="image-preview"
                        class="w-20 h-20 sm:w-24 sm:h-24 bg-zinc-200 rounded-full flex items-center justify-center overflow-hidden flex-shrink-0">
                        @if ($employee->photo)
                            <img src="{{ asset('/storage/' . $employee->photo) }}" alt="Uploaded Picture"
                                class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-400 text-xs sm:text-sm">Preview</span>
                        @endif
                    </div>

                    <div class="flex-1 text-center sm:text-left">
                        @if ($employee->photo)
                            <input type="hidden" name="old_photo" id="old_photo" value="{{ $employee->photo }}">
                        @endif

                        <div class="mb-3 sm:mb-4">
                            <h1 class="font-semibold text-lg sm:text-xl">
                                {{ $employee->user->name ?? 'Tidak ada username' }}</h1>
                            <p class="text-xs sm:text-sm text-gray-600">
                                {{ $employee->role->name ?? 'Tidak ada divisi' }}</p>
                        </div>

                        <div class="flex flex-col xss:flex-row gap-2 xss:gap-3 justify-center sm:justify-start">
                            <label for="photo"
                                class="cursor-pointer bg-sky-blue text-white text-xs font-medium px-3 sm:px-4 py-1.5 sm:py-1 rounded hover:bg-blue-600 transition-colors text-center">
                                Upload Foto
                            </label>
                            <input id="photo" name="photo" type="file" accept="image/*" class="hidden" />

                            <button id="delete-button" type="button"
                                class="bg-secondary-white text-[#7D7D7D] px-3 sm:px-4 py-1.5 sm:py-1 text-xs rounded font-medium hover:bg-gray-100 transition-colors">
                                Hapus Foto
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="mt-6 sm:mt-8 lg:mt-10 space-y-4 sm:space-y-6">

                    <!-- Email Fields Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                        <!-- Account Email -->
                        <div class="flex flex-col space-y-1">
                            <label for="email" class="primary-gray font-medium text-sm">Email Akun</label>
                            <input
                                class="w-full primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan email akun" type="email" name="email" id="email"
                                value="{{ old('email', $employee->user->email) }}">
                            @error('email')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Work Email -->
                        <div class="flex flex-col space-y-1">
                            <label for="work_email" class="primary-gray font-medium text-sm">Email Kantor</label>
                            <input
                                class="w-full primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan email perusahaan" type="email" name="work_email" id="work_email"
                                value="{{ old('work_email', $employee->work_email) }}">
                            @error('work_email')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- NIK and Phone Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                        <!-- NIK -->
                        <div class="flex flex-col space-y-1">
                            <label for="nik" class="primary-gray font-medium text-sm">NIK</label>
                            <input
                                class="w-full primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan NIK" type="text" name="nik" id="nik"
                                value="{{ old('nik', $employee->nik) }}">
                            @error('nik')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="flex flex-col space-y-1">
                            <label for="phone_number" class="primary-gray font-medium text-sm">No. HP</label>
                            <input
                                class="w-full primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan no. hp" type="text" name="phone_number" id="phone_number"
                                value="{{ old('phone_number', $employee->phone_number) }}">
                            @error('phone_number')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Address and Education Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                        <!-- Address -->
                        <div class="flex flex-col space-y-1">
                            <label for="address" class="primary-gray font-medium text-sm">Alamat</label>
                            <input
                                class="w-full primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan alamat" type="text" name="address" id="address"
                                value="{{ old('address', $employee->address) }}">
                            @error('address')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Education -->
                        <div class="flex flex-col space-y-1">
                            <label for="education" class="primary-gray font-medium text-sm">Pendidikan Terakhir</label>
                            <input
                                class="w-full primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan pendidikan terakhir" type="text" name="education"
                                id="education" value="{{ old('education', $employee->education) }}">
                            @error('education')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Birth Date and Join Date Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                        <!-- Birth Date -->
                        <div class="flex flex-col space-y-1">
                            <label for="birth_date" class="primary-gray font-medium text-sm">Tanggal Lahir</label>
                            <input
                                class="w-full primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                type="date" name="birth_date" id="birth_date"
                                value="{{ old('birth_date', $employee->birth_date) }}">
                            @error('birth_date')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Join Date -->
                        <div class="flex flex-col space-y-1">
                            <label for="join_date" class="primary-gray font-medium text-sm">Tanggal Masuk</label>
                            <input
                                class="w-full primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                type="date" name="join_date" id="join_date"
                                value="{{ old('join_date', $employee->join_date) }}">
                            @error('join_date')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Status Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                        <!-- Status SDM -->
                        <div class="flex flex-col space-y-1">
                            <label for="status" class="primary-gray font-medium text-sm">Status SDM</label>
                            <select name="status" id="status"
                                class="w-full primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status', $employee->status) === $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Custom Permissions Section -->
                <div id="custom_permissions_section" class="mt-6 sm:mt-8 border-t pt-4 sm:pt-6">
                    <h3 class="primary-gray font-medium text-sm mb-3">Hak Akses (Permissions)</h3>

                    @if ($hasCustomPermissions)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                            <p class="text-xs text-green-800">✓ Pengguna ini menggunakan hak akses khusus (custom)</p>
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
                            <p class="text-xs flex flex-col sm:flex-row sm:items-center mb-1">
                                <svg class="w-4 h-4 mr-0 sm:mr-2 mb-1 sm:mb-0 flex-shrink-0" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"
                                        fill="#2c5282" />
                                </svg>
                                <span>Pengguna ini menggunakan hak akses default sesuai role:
                                    <strong>{{ $employee->role->name ?? 'Tidak ada role' }}</strong></span>
                            </p>
                            <p class="text-xs flex flex-col sm:flex-row sm:items-center">
                                <svg class="w-4 h-4 mr-0 sm:mr-2 mb-1 sm:mb-0 flex-shrink-0" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                                        fill="#3182ce" />
                                </svg>
                                <span><span class="font-semibold">Kustomisasi:</span> Centang kotak untuk mengubah hak
                                    akses default</span>
                            </p>
                        </div>
                    @endif

                    <div class="space-y-3">
                        @foreach ($pages as $page)
                            @php
                                $permission = $userPermissions[$page->id] ?? null;
                            @endphp
                            <div class="border border-gray-300 rounded-lg p-3">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                                    <span class="font-medium text-sm capitalize">{{ $page->teks }}</span>
                                    <div class="grid grid-cols-2 sm:flex sm:space-x-3 gap-2 sm:gap-0">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_view_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_view]" value="1"
                                                class="mr-1"
                                                {{ $permission && $permission['allow_view'] ? 'checked' : '' }}>
                                            <label for="allow_view_{{ $page->id }}" class="text-xs">View</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_create_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_create]" value="1"
                                                class="mr-1"
                                                {{ $permission && $permission['allow_create'] ? 'checked' : '' }}>
                                            <label for="allow_create_{{ $page->id }}"
                                                class="text-xs">Create</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_update_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_update]" value="1"
                                                class="mr-1"
                                                {{ $permission && $permission['allow_update'] ? 'checked' : '' }}>
                                            <label for="allow_update_{{ $page->id }}"
                                                class="text-xs">Update</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_delete_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_delete]" value="1"
                                                class="mr-1"
                                                {{ $permission && $permission['allow_delete'] ? 'checked' : '' }}>
                                            <label for="allow_delete_{{ $page->id }}"
                                                class="text-xs">Delete</label>
                                        </div>
                                        <!-- Hidden fields untuk compatibility -->
                                        <input type="hidden" name="permissions[{{ $page->id }}][allow_export]"
                                            value="0">
                                        <input type="hidden" name="permissions[{{ $page->id }}][allow_import]"
                                            value="0">
                                        <input type="hidden" name="permissions[{{ $page->id }}][allow_edit]"
                                            value="0">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-gray-50 rounded-lg p-3 mt-3">
                        <p class="text-xs text-gray-600 flex flex-col sm:flex-row sm:items-center">
                            @if ($hasCustomPermissions)
                                <svg class="w-6 h-6 mr-0 sm:mr-2 mb-1 sm:mb-0 flex-shrink-0" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"
                                        fill="#ed8936" />
                                </svg>
                                <span>Kosongkan semua kotak untuk kembali menggunakan hak akses default sesuai
                                    role.</span>
                            @else
                                <svg class="w-6 h-6 mr-0 sm:mr-2 mb-1 sm:mb-0 flex-shrink-0" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"
                                        fill="#ed8936" />
                                </svg>
                                <span>Centang kotak untuk memberikan hak akses khusus. Jika tidak ada yang dicentang,
                                    sistem akan menggunakan hak akses default sesuai role.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 sm:mt-8 lg:mt-9 flex justify-center">
                    <button type="submit"
                        class="bg-primary-black hover:bg-zinc-500 text-white text-sm px-8 sm:px-10 py-2 sm:py-1 rounded-lg transition-colors w-full sm:w-auto">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handler untuk upload foto
            const photoInput = document.getElementById('photo');
            const imagePreview = document.getElementById('image-preview');
            const deleteButton = document.getElementById('delete-button');

            if (photoInput) {
                photoInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.innerHTML =
                                `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Handler untuk hapus foto
            if (deleteButton) {
                deleteButton.addEventListener('click', function() {
                    // Reset preview ke kondisi awal
                    imagePreview.innerHTML = '<span class="text-gray-400 text-sm">Preview</span>';
                    // Reset input file
                    if (photoInput) {
                        photoInput.value = '';
                    }
                    // Jika ada old_photo input, kosongkan nilainya
                    const oldPhotoInput = document.getElementById('old_photo');
                    if (oldPhotoInput) {
                        oldPhotoInput.value = '';
                    }
                });
            }

            // Handler untuk role selection (jika ada role_id select)
            const roleSelect = document.getElementById('role_id');
            if (roleSelect) {
                const roleInfo = {
                    '1': 'Analyst: Default bisa liat project, sama bikin/update/edit task',
                    '2': 'Project Director: Default punya akses penuh ke semua fitur (level admin)',
                    '3': 'Designer: Default bisa liat project, sama bikin/update/edit task',
                    '4': 'Engineer Web: Default bisa liat project, sama bikin/update/edit task',
                    '5': 'Engineer Mobile: Default bisa liat project, sama bikin/update/edit task',
                    '6': 'Engineer Tester: Default bisa liat project, sama bikin/update/edit task'
                };

                roleSelect.addEventListener('change', function() {
                    const roleId = this.value;
                    const infoElement = document.querySelector('.role-info');
                    if (infoElement && roleInfo[roleId]) {
                        infoElement.textContent = roleInfo[roleId];
                    }
                });

                // Buat elemen info untuk role
                const infoElement = document.createElement('p');
                infoElement.className = 'role-info text-xs text-blue-600 mt-1';
                infoElement.textContent = 'Pilih role dulu buat liat info permission default';
                roleSelect.parentNode.appendChild(infoElement);
            }

            // Handler untuk permission checkboxes - auto-check View
            const permissionSection = document.getElementById('custom_permissions_section');
            if (permissionSection) {
                const permissionCheckboxes = permissionSection.querySelectorAll('input[type="checkbox"]');

                permissionCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const checkboxId = this.id;
                        const pageId = checkboxId.split('_').pop();
                        const viewCheckbox = document.getElementById(`allow_view_${pageId}`);

                        if (!viewCheckbox) return; // Skip jika view checkbox tidak ditemukan

                        // Jika checkbox yang diklik adalah Create, Update, atau Delete
                        if (checkboxId.includes('allow_create_') ||
                            checkboxId.includes('allow_update_') ||
                            checkboxId.includes('allow_delete_')) {

                            // Jika checkbox tersebut dicentang, otomatis centang View
                            if (this.checked) {
                                viewCheckbox.checked = true;
                            }
                        }

                        // Jika checkbox View di-uncheck, otomatis uncheck semua yang lain
                        if (checkboxId.includes('allow_view_') && !this.checked) {
                            const createCheckbox = document.getElementById(
                                `allow_create_${pageId}`);
                            const updateCheckbox = document.getElementById(
                                `allow_update_${pageId}`);
                            const deleteCheckbox = document.getElementById(
                                `allow_delete_${pageId}`);

                            if (createCheckbox) createCheckbox.checked = false;
                            if (updateCheckbox) updateCheckbox.checked = false;
                            if (deleteCheckbox) deleteCheckbox.checked = false;
                        }
                    });
                });
            }

            console.log('JavaScript berhasil dimuat dan event listeners telah terpasang');
        });
    </script>
</x-layouts.layout>
