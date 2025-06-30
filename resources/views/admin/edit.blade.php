<x-layouts.layout :title="$title" :active="$active">
    <main class="flex flex-col items-center justify-center">
        <div class="bg-white w-[60%] py-9 px-12 rounded-xl border border-gray-200">
            <form action="{{ route('admin.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex items-center">
                    <div id="image-preview"
                        class="w-24 h-24 bg-zinc-200 rounded-full flex items-center justify-center overflow-hidden">
                        @if ($employee->photo)
                            <img src="{{ asset('/storage/' . $employee->photo) }}" alt="Uploaded Picture"
                                class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-400 text-sm">Preview</span>
                        @endif
                    </div>
                    <div>
                        @if ($employee->photo)
                            <input type="hidden" name="old_photo" id="old_photo" value="{{ $employee->photo }}">
                        @endif
                        <div class="ml-5">
                            <h1 class="font-semibold text-xl">{{ $employee->user->name ?? 'Tidak ada username' }}</h1>
                            <p class="tex-xs">{{ $employee->role->name ?? 'Tidak ada divisi' }}</p>
                        </div>
                        <div class="flex mt-2">
                            <div class="ml-5 mr-3">
                                <label for="photo"
                                    class="cursor-pointer bg-sky-blue text-white text-xs font-medium px-4 py-1 rounded hover:bg-blue-600">
                                    Upload Foto
                                </label>
                                <input id="photo" name="photo" type="file" accept="image/*" class="hidden" />
                            </div>
                            <button id="delete-button" type="button"
                                class="bg-secondary-white text-[#7D7D7D] px-4 py-1 text-xs rounded font-medium">Hapus
                                Foto
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex mt-10 w-full">
                    <!-- Work Email Input -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="work_email" class="primary-gray font-medium text-sm">Email Perusahaan</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Masukkan email perusahaan" type="email" name="work_email" id="work_email"
                            value="{{ old('work_email', $employee->work_email) }}">
                        @error('work_email')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- NIK Input -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="nik" class="primary-gray font-medium text-sm">NIK</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Masukkan NIK" type="text" name="nik" id="nik"
                            value="{{ old('nik', $employee->nik) }}">
                        @error('nik')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex mt-3 w-full">
                    <!-- Status SDM Input -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="status" class="primary-gray font-medium text-sm">Status SDM</label>
                        <select name="status" id="status"
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none">
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

                    <!-- Phone Number Input -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="phone_number" class="primary-gray font-medium text-sm">No. HP</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Masukkan no. hp" type="text" name="phone_number" id="phone_number"
                            value="{{ old('phone_number', $employee->phone_number) }}">
                        @error('phone_number')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex mt-3 w-full">
                    <!-- Address -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="address" class="primary-gray font-medium text-sm">Alamat</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Masukkan alamat" type="text" name="address" id="address"
                            value="{{ old('address', $employee->address) }}">
                        @error('address')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Birth Date -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="birth_date" class="primary-gray font-medium text-sm">Tanggal Lahir</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            type="date" name="birth_date" id="birth_date"
                            value="{{ old('birth_date', $employee->birth_date) }}">
                        @error('birth_date')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex mt-3 w-full">
                    <!-- Join Date Input -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="join_date" class="primary-gray font-medium text-sm">Tanggal Masuk</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            type="date" name="join_date" id="join_date"
                            value="{{ old('join_date', $employee->join_date) }}">
                        @error('join_date')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Education -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="education" class="primary-gray font-medium text-sm">Pendidikan Terakhir</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Masukkan pendidikan terakhir" type="text" name="education"
                            id="education" value="{{ old('education', $employee->education) }}">
                        @error('education')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Custom Permissions Section -->
                <div id="custom_permissions_section" class="mt-6 border-t pt-4">
                    <h3 class="primary-gray font-medium text-sm mb-3">Hak Akses (Permissions)</h3>

                    @if ($hasCustomPermissions)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                            <p class="text-xs text-green-800">✓ Pengguna ini menggunakan hak akses khusus (custom)</p>
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
                            <p class="text-xs text-blue-800 mb-1">
                                ℹ Pengguna ini menggunakan hak akses default sesuai role:
                                <strong>{{ $employee->role->name ?? 'Tidak ada role' }}</strong>
                            </p>
                            <p class="text-xs text-orange-600">
                                💡 Centang kotak di bawah untuk memberikan hak akses khusus (custom)
                            </p>
                        </div>
                    @endif

                    <div class="space-y-3">
                        @foreach ($pages as $page)
                            @php
                                $permission = $userPermissions[$page->id] ?? null;
                            @endphp
                            <div class="border border-gray-300 rounded-lg p-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-sm capitalize">{{ $page->teks }}</span>
                                    <div class="flex space-x-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_view_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_view]" value="1"
                                                {{ $permission && $permission['allow_view'] ? 'checked' : '' }}>
                                            <label for="allow_view_{{ $page->id }}"
                                                class="ml-1 text-xs">View</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_create_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_create]" value="1"
                                                {{ $permission && $permission['allow_create'] ? 'checked' : '' }}>
                                            <label for="allow_create_{{ $page->id }}"
                                                class="ml-1 text-xs">Create</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_update_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_update]" value="1"
                                                {{ $permission && $permission['allow_update'] ? 'checked' : '' }}>
                                            <label for="allow_update_{{ $page->id }}"
                                                class="ml-1 text-xs">Update</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_delete_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_delete]" value="1"
                                                {{ $permission && $permission['allow_delete'] ? 'checked' : '' }}>
                                            <label for="allow_delete_{{ $page->id }}"
                                                class="ml-1 text-xs">Delete</label>
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
                        <p class="text-xs text-gray-600">
                            @if ($hasCustomPermissions)
                                <strong>Catatan:</strong> Kosongkan semua kotak untuk kembali menggunakan hak akses
                                default sesuai role.
                            @else
                                <strong>Catatan:</strong> Centang kotak untuk memberikan hak akses khusus. Jika tidak
                                ada yang dicentang, sistem akan menggunakan hak akses default sesuai role.
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mt-9 flex justify-center">
                    <button type="submit"
                        class="bg-primary-black hover:bg-zinc-500 text-white text-sm px-10 py-1 rounded-lg">Simpan</button>
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
                            imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
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
                            const createCheckbox = document.getElementById(`allow_create_${pageId}`);
                            const updateCheckbox = document.getElementById(`allow_update_${pageId}`);
                            const deleteCheckbox = document.getElementById(`allow_delete_${pageId}`);

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