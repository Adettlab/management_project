<x-layouts.layout :title="$title" :active="$active">
    <main class="h-auto flex flex-col items-center justify-center py-8">
        <div class="bg-white w-[80%] md:w-[60%] py-9 px-12 rounded-xl border border-gray-200">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <h1 class="font-semibold text-xl mb-6 text-center">Bikin Akun Baru</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Username Input -->
                    <div class="flex flex-col space-y-1">
                        <label for="username" class="primary-gray font-medium text-sm">Username</label>
                        <input
                            class="primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none"
                            placeholder="Masukin username" type="text" id="username" name="name"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="flex flex-col space-y-1">
                        <label for="password" class="primary-gray font-medium text-sm">Password</label>
                        <input
                            class="primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none"
                            placeholder="Masukin password" type="password" id="password" name="password" required>
                        @error('password')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Email Input -->
                    <div class="flex flex-col space-y-1">
                        <label for="email" class="primary-gray font-medium text-sm">Email Akun</label>
                        <input
                            class="primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none"
                            placeholder="Masukin email" type="email" id="email" name="email"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="flex flex-col space-y-1">
                        <label for="password_confirmation" class="primary-gray font-medium text-sm">Konfirmasi
                            Password</label>
                        <input
                            class="primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none"
                            placeholder="Konfirmasi password" type="password" id="password_confirmation"
                            name="password_confirmation" required>
                        @error('password_confirmation')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Work Email Input -->
                    <div class="flex flex-col space-y-1">
                        <label for="work_email" class="primary-gray font-medium text-sm">Email Kantor</label>
                        <input
                            class="primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none"
                            placeholder="Masukin email kantor" type="email" id="work_email" name="work_email"
                            value="{{ old('work_email') }}" required>
                        @error('work_email')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Empty div for grid alignment -->
                    <div></div>
                </div>

                <!-- Role Selection -->
                <div class="mt-6">
                    <label for="role_id" class="primary-gray font-medium text-sm">Divisi</label>
                    <select name="role_id" id="role_id"
                        class="w-full primary-gray font-medium rounded-lg py-2 px-3 text-sm border border-gray-200 outline-none"
                        required>
                        <option value="">Pilih Divisi</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Custom Permissions Section -->
                <div id="custom_permissions_section" class="mt-6 w-full">
                    <label class="primary-gray font-medium text-sm">Atur Permission Khusus (Opsional)</label>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
                        <p class="text-xs text-blue-800 mb-1">
                            <strong>Default:</strong> Setiap role udah punya permission bawaan dari sistem.
                        </p>
                        <p class="text-xs text-blue-600">
                            <strong>Permission Khusus:</strong> Centang kotak di bawah cuma kalau mau GANTI permission
                            default role-nya.
                            <br>Kalau gak dicentang sama sekali, nanti pake permission standar sesuai role aja.
                        </p>
                    </div>
                    <div class="space-y-4 mt-2">
                        @foreach ($pages as $page)
                            <div class="border border-gray-300 rounded-lg p-4">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-sm capitalize">{{ $page->teks }}</span>
                                    <div class="flex space-x-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_view_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_view]" value="1">
                                            <label for="allow_view_{{ $page->id }}"
                                                class="ml-2 text-sm">View</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_create_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_create]" value="1">
                                            <label for="allow_create_{{ $page->id }}"
                                                class="ml-2 text-sm">Create</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_update_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_update]" value="1">
                                            <label for="allow_update_{{ $page->id }}"
                                                class="ml-2 text-sm">Update</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="allow_delete_{{ $page->id }}"
                                                name="permissions[{{ $page->id }}][allow_delete]" value="1">
                                            <label for="allow_delete_{{ $page->id }}"
                                                class="ml-2 text-sm">Delete</label>
                                        </div>
                                        <!-- Export, Import, Edit fields disembunyikan karena gak dipake -->
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
                    <p class="text-xs text-gray-500 mt-2">
                        <strong>Catatan:</strong> Kalau gak ada permission khusus yang dipilih, sistem bakal otomatis
                        pake permission default sesuai role yang udah diatur di kode.
                    </p>
                </div>

                <div class="mt-9 mb-4 flex justify-center">
                    <button type="submit"
                        class="bg-primary-black hover:bg-zinc-500 text-white text-sm px-10 py-1 rounded-lg">Bikin
                        Akun</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Script yang sudah ada untuk role selection
        document.getElementById('role_id').addEventListener('change', function() {
            const roleId = this.value;

            const roleInfo = {
                '1': 'Analyst: Default bisa liat project, sama bikin/update/edit task',
                '2': 'Project Director: Default punya akses penuh ke semua fitur (level admin)',
                '3': 'Designer: Default bisa liat project, sama bikin/update/edit task',
                '4': 'Engineer Web: Default bisa liat project, sama bikin/update/edit task',
                '5': 'Engineer Mobile: Default bisa liat project, sama bikin/update/edit task',
                '6': 'Engineer Tester: Default bisa liat project, sama bikin/update/edit task'
            };

            const infoElement = document.querySelector('.role-info');
            if (infoElement && roleInfo[roleId]) {
                infoElement.textContent = roleInfo[roleId];
            }
        });

        // Script untuk auto-check View ketika Create, Update, atau Delete dicentang
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua checkbox permissions
            const permissionCheckboxes = document.querySelectorAll(
                '#custom_permissions_section input[type="checkbox"]');

            // Tambahkan event listener untuk setiap checkbox
            permissionCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkboxId = this.id;
                    const pageId = checkboxId.split('_').pop();

                    const viewCheckbox = document.getElementById(`allow_view_${pageId}`);

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
                        document.getElementById(`allow_create_${pageId}`).checked = false;
                        document.getElementById(`allow_update_${pageId}`).checked = false;
                        document.getElementById(`allow_delete_${pageId}`).checked = false;
                    }
                });
            });

            // Tambahin elemen info setelah pemilihan role
            const roleSelect = document.getElementById('role_id');
            const infoElement = document.createElement('p');
            infoElement.className = 'role-info text-xs text-blue-600 mt-1';
            infoElement.textContent = 'Pilih role dulu buat liat info permission default';
            roleSelect.parentNode.appendChild(infoElement);
        });
    </script>
</x-layouts.layout>
