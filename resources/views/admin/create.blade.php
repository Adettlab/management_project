<x-layouts.layout :title="$title" :active="$active">
    <main class="sm:h-full flex flex-col items-center justify-center">
        <div
            class="bg-white sm:w-[60%] xs:w-[90vw] py-9 px-12 rounded-xl border border-gray-200 sm:shadow-none xs:shadow-[0_0_3px_3px_rgba(0,0,0,0.05)]">
            <form action="{{ route('admin.store') }}" method="POST" onsubmit="return validateForm()">
                @csrf
                <h1 class="font-semibold sm:text-xl xs:text-[16px] text-center">Bikin Akun Baru</h1>

                <div class="flex sm:flex-row xs:flex-col sm:mt-10 xs:mt-5 w-full">

                    <!-- Username Input -->
                    <div class="sm:w-1/2 flex flex-col space-y-1 xs:mb-3 sm:mb-0">
                        <label for="username"
                            class="primary-gray font-medium sm:text-sm xs:text-[10px] flex items-center">Username <span
                                class="bg-red-100 ml-1 text-red-600 px-1 py-[1px] flex items-center h-4 rounded-full text-[7px] font-semibold"
                                data-required-label="username">Required</span></label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg sm:py-1 xs:py-2 px-2 sm:text-sm xs:text-[12px] border border-gray-200 outline-none"
                            placeholder="Enter username" type="text" id="username" name="name"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="sm:w-1/2 flex flex-col space-y-1">
                        <label for="password"
                            class="primary-gray font-medium sm:text-sm xs:text-[10px] flex items-center">Password <span
                                class="bg-red-100 ml-1 text-red-600 px-1 py-[1px] flex items-center h-4 rounded-full text-[7px] font-semibold"
                                data-required-label="password">Required</span></label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg sm:py-1 xs:py-2 px-2 sm:text-sm xs:text-[12px] border border-gray-200 outline-none"
                            placeholder="Enter password" type="text" id="password" name="password" required>
                        @error('password')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex sm:flex-row xs:flex-col mt-3 w-full sm:mb-0">
                    <!-- Email Input -->
                    <div class="sm:w-1/2 flex flex-col space-y-1 sm:mb-0 xs:mb-3">
                        <label for="email"
                            class="primary-gray font-medium sm:text-sm xs:text-[10px] flex items-center">Email
                            Akun <span
                                class="bg-red-100 ml-1 text-red-600 px-1 py-[1px] flex items-center h-4 rounded-full text-[7px] font-semibold"
                                data-required-label="email">Required</span></label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg sm:py-1 xs:py-2 px-2 sm:text-sm xs:text-[12px] border border-gray-200 outline-none"
                            placeholder="Enter email" type="email" id="email" name="email"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="sm:w-1/2 flex flex-col space-y-1">
                        <label for="password_confirmation"
                            class="primary-gray font-medium sm:text-sm xs:text-[10px] flex items-center">Confirm
                            password <span
                                class="bg-red-100 ml-1 text-red-600 px-1 py-[1px] flex items-center h-4 rounded-full text-[7px] font-semibold"
                                data-required-label="password_confirmation">Required</span></label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg sm:py-1 xs:py-2 px-2 sm:text-sm xs:text-[12px] border border-gray-200 outline-none"
                            placeholder="Confirm password" type="text" id="password_confirmation"
                            name="password_confirmation" required>
                        @error('password_confirmation')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex sm:flex-row xs:flex-col mt-3 w-full sm:mb-0">
                    <!-- Word Email Input -->
                    <div class="sm:w-1/2 flex flex-col space-y-1 sm:mb-0 xs:mb-3">
                        <label for="work_email"
                            class="primary-gray font-medium sm:text-sm xs:text-[10px] flex items-center">Email
                            Kantor <span
                                class="bg-red-100 ml-1 text-red-600 px-1 py-[1px] flex items-center h-4 rounded-full text-[7px] font-semibold"
                                data-required-label="work_email">Required</span></label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg sm:py-1 xs:py-2 px-2 sm:text-sm xs:text-[12px] border border-gray-200 outline-none"
                            placeholder="Enter email kantor" type="email" id="work_email" name="work_email"
                            value="{{ old('work_email') }}" required>
                        @error('work_email')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Role Selection -->
                    <div class="sm:w-1/2 flex flex-col space-y-1">
                        <label for="role_id"
                            class="primary-gray font-medium sm:text-sm xs:text-[10px] flex items-center">Division <span
                                class="bg-red-100 ml-1 text-red-600 px-1 py-[1px] flex items-center h-4 rounded-full text-[7px] font-semibold"
                                data-required-label="role_id">Required</span></label>
                        <select name="role_id" id="role_id" required
                            class="w-[94%] primary-gray font-medium rounded-lg sm:py-1 xs:py-2 px-2 sm:text-sm xs:text-[12px] border border-gray-200 outline-none">
                            <option value="">Enter division</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Custom Permissions Section -->
                <div id="custom_permissions_section" class="mt-6 w-full">
                    <label class="primary-gray font-medium text-sm flex items-center"> <svg class="size-5 mr-1"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"
                                fill="#2c5282" />
                        </svg>Atur Hak Akses Permission<span
                            class="bg-blue-100 ml-1 text-blue-600 px-1 py-[1px] py-2 flex items-center h-4 rounded-full text-[7px] font-semibold">Optional</span></label>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3 mt-2">
                        <p class="text-xs mb-[4px] flex">
                            <svg class="size-4 mr-2" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"
                                    fill="#38a169" />
                            </svg>
                            <span class="font-semibold">Default:</span> &nbsp;Role sudah punya hak akses standar
                        </p>
                        <p class="text-xs mb-[4px] flex">
                            <svg class="size-4 mr-2" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                                    fill="#3182ce" />
                            </svg>
                            <span class="font-semibold">Kustomisasi:</span> &nbsp;Centang kotak untuk mengubah hak
                            akses
                            default
                        </p>
                        <p class="text-xs flex">
                            <svg class="size-4 mr-2" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"
                                    fill="#ed8936" />
                            </svg>
                            <span class="font-semibold">Rekomendasi:</span> &nbsp;Biarkan kosong untuk menggunakan
                            pengaturan
                            standar
                        </p>
                    </div>
                    <div class="space-y-4 mt-2">
                        @foreach ($pages as $page)
                            <div class="border border-gray-300 rounded-lg p-4">
                                <div class="flex sm:justify-between sm:items-center flex-col sm:flex-row">
                                    <div class="font-medium text-sm capitalize">{{ $page->teks }}</div>
                                    <div class="flex space-x-4 sm:flex-row">
                                        <div class="flex sm:space-x-4 flex-col sm:flex-row">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="allow_view_{{ $page->id }}"
                                                    name="permissions[{{ $page->id }}][allow_view]"
                                                    value="1">
                                                <label for="allow_view_{{ $page->id }}"
                                                    class="ml-2 text-sm">View</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="allow_create_{{ $page->id }}"
                                                    name="permissions[{{ $page->id }}][allow_create]"
                                                    value="1">
                                                <label for="allow_create_{{ $page->id }}"
                                                    class="ml-2 text-sm">Create</label>
                                            </div>
                                        </div>
                                        <div class="flex sm:space-x-4 flex-col sm:flex-row">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="allow_update_{{ $page->id }}"
                                                    name="permissions[{{ $page->id }}][allow_update]"
                                                    value="1">
                                                <label for="allow_update_{{ $page->id }}"
                                                    class="ml-2 text-sm">Update</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="allow_delete_{{ $page->id }}"
                                                    name="permissions[{{ $page->id }}][allow_delete]"
                                                    value="1">
                                                <label for="allow_delete_{{ $page->id }}"
                                                    class="ml-2 text-sm">Delete</label>
                                            </div>
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
                </div>

                <div class="mt-9 mb-4 flex justify-center">
                    <button type="submit"
                        class="bg-primary-black hover:bg-zinc-500 text-white sm:text-sm xs:text-[12px] px-10 sm:py-1 xs:py-2 rounded-lg">Create
                        Account</button>
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
            // const roleSelect = document.getElementById('role_id');
            // const infoElement = document.createElement('p');
            // infoElement.className = 'role-info text-xs text-blue-600 mt-1';
            // infoElement.textContent = 'Pilih role dulu buat liat info permission default';
            // roleSelect.parentNode.appendChild(infoElement);
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua input yang memiliki atribut required
            const requiredInputs = document.querySelectorAll(
                'input[required], textarea[required], select[required]');

            requiredInputs.forEach(function(input) {
                const label = document.querySelector(`span[data-required-label="${input.id}"]`);

                if (!label) return; // Lewati kalau tidak ada label

                function toggleLabel() {
                    if (input.value.trim() !== '') {
                        label.style.display = 'none';
                    } else {
                        label.style.display = '';
                    }
                }

                toggleLabel(); // Set awal
                input.addEventListener('input', toggleLabel);
            });
        });
    </script>

</x-layouts.layout>
