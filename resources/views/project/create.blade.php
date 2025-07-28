<x-layouts.layout :title="$title" :active="$active">
    <main class="flex sm:space-x-4">
        <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data"
            class="flex-1 flex sm:items-start xs:items-center sm:flex-row xs:flex-col" id="create_project">
            @csrf
            <div
                class="bg-white rounded sm:shadow xs:shadow-[0px_0px_5px_0.5px_rgba(0,0,0,0.1)] sm:w-2/5 xs:w-[95%] pt-4 sm:px-5 xs:px-3 pb-4 sm:mr-4 xs:mb-5 sm:mb-0">
                <div class="flex sm:flex-row xs:flex-col sm:items-center xs:items-start justify-between mb-2">
                    <h1 class="sm:text-2xl xs:text-[16px] font-semibold">New Project</h1>
                    @if ($errors->has('error'))
                        <div class="flex bg-red-100 rounded-lg sm:p-2 sm:text-xs xs:text-[11px] text-red-700"
                            role="alert">
                            <svg class="w-4 h-4 inline mr-3" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                {{ $errors->first('error') }}
                            </div>
                        </div>
                    @endif
                </div>
                <div class="space-y-4 mt-6">
                    <div class="flex flex-col space-y-2">
                        <label class="block sm:text-lg xs:text-[10px] text-primary-white " for="name">Project
                            name<span
                                class="bg-red-100 ml-1 text-red-600 px-2 py-1 my-auto rounded-full text-[8px] font-semibold"
                                data-required-label="name">Required</span></label>
                        <input type="text" name="name" id="name"
                            class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                            placeholder="project name.." required value="{{ old('name') }}">
                        @error('name')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="block sm:text-lg xs:text-[10px] text-primary-white">Date <span
                                class="bg-red-100 ml-1 text-red-600 px-2 py-1 rounded-full text-[8px] font-semibold"
                                data-required-label="date">Required</span></label>
                        <div class="flex items-center justify-between w-full gap-4">
                            <div class="flex sm:flex-row xs:flex-col sm:items-center xs:items-start w-[50%] gap-2">
                                <label for="start_date" class="sm:text-sm xs:text-[12px] text-gray-700">Start:</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                                    required value="{{ old('start_date') }}">
                            </div>
                            <div class="flex sm:flex-row xs:flex-col sm:items-center xs:items-start w-[50%] gap-1">
                                <label for="end_date" class="sm:text-sm xs:text-[12px] text-gray-700">End:</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="w-full bg-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none border border-primary-white"
                                    required value="{{ old('end_date') }}">

                            </div>
                        </div>
                        @error('start_date')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                        @error('end_date')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="block sm:text-lg xs:text-[10px] text-primary-white" for="level">Level
                            Project <span
                                class="bg-red-100 ml-1 text-red-600 px-2 py-1 rounded-full text-[8px] font-semibold"
                                data-required-label="level">Required</span></label>
                        <select name="project_level_id"
                            class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                            id="level" required>
                            <option value="">Select level project</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}"
                                    {{ old('project_level_id') == $level->id ? 'selected' : '' }}>{{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_level_id')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="block sm:text-lg xs:text-[10px] text-primary-white" for="status">Status <span
                                class="bg-red-100 ml-1 text-red-600 px-2 py-1 rounded-full text-[8px] font-semibold"
                                data-required-label="status">Required</span></label>
                        <select name="project_status_id"
                            class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                            id="status" required>
                            <option value="">Select status project</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}"
                                    {{ old('project_status_id') == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}</option>
                            @endforeach
                        </select>
                        @error('project_status_id')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="block sm:text-lg xs:text-[10px] text-primary-white" for="description">Project
                            Description <span
                                class="bg-blue-100 ml-1 text-blue-600 px-2 py-1 rounded-full text-[8px] font-semibold">Optional</span></label>
                        <textarea name="description" id="description" rows="2"
                            placeholder="project description.."class="w-full bg-primary-white border border-primary-white px-3 py-1 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                            value="{{ old('description') }}"></textarea>
                        @error('description')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded sm:shadow xs:shadow-[0px_0px_5px_0.5px_rgba(0,0,0,0.1)] sm:w-3/5 xs:w-[95%] sm:h-full xs:h-[35rem] pt-4 sm:px-5 xs:px-3 pb-4 xs:mb-5 sm:mb-0 xs:relative sm:static">
                <h1 class="sm:text-2xl xs:text-[16px] font-semibold mb-2">SDM</h1>
                <div class="space-y-4 mt-6">
                    <div class="flex flex-col space-y-2">
                        <label class="block sm:text-lg xs:text-[10px] text-primary-white" for="director">KEPALA PUSTIK
                            <span class="bg-red-100 ml-1 text-red-600 px-2 py-1 rounded-full text-[8px] font-semibold"
                                data-required-label="director">Required</span></label>
                        <select name="kepala_id"
                            class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                            id="director" required>
                            <option value="">Select KEPALA PUSTIK</option>
                            @foreach ($employees->where('role.name', 'KEPALA PUSTIK') as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ old('kepala_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->user->name }}</option>
                            @endforeach
                        </select>
                        @error('kepala_id')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col space-y-2">
                        <label class="block sm:text-lg xs:text-[10px] text-primary-white">Tambah SDM
                            <span
                                class="bg-blue-100 ml-1 text-blue-600 px-2 py-1 rounded-full text-[8px] font-semibold">Optional</span>
                        </label>

                        <!-- Container untuk input SDM yang akan ditambahkan dinamis -->
                        <div id="sdm-inputs-container" class="space-y-3">
                            <!-- Input SDM akan ditambahkan di sini secara dinamis -->
                        </div>

                        <!-- Tombol untuk menambah input SDM -->
                        <div class="pt-2">
                            <button type="button" onclick="addInput()"
                                class="bg-black hover:bg-gray-800 text-white sm:text-xs xs:text-[11px] sm:px-4 sm:py-2 xs:px-3 xs:py-1 rounded-md transition-colors">
                                Tambah SDM
                            </button>
                        </div>

                        @error('sdm_ids')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                        @error('sdm_ids.*')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- <div class="flex flex-col space-y-2">
                        <label class="block sm:text-lg xs:text-[10px] text-primary-white" for="analyst">Project
                            Pelaporan PDDIKTI <span
                                class="bg-blue-100 ml-1 text-blue-600 px-2 py-1 rounded-full text-[8px] font-semibold">Optional</span></label>
                        <select name="pelaporan_pddikti_id"
                            class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                            id="analyst">
                            <option value="">Select pelaporan PDDIKTI</option>
                            @foreach ($employees->where('role.name', 'Pelaporan PDDIKTI') as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ old('pelaporan_pddikti_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->user->name }}</option>
                            @endforeach
                        </select>
                        @error('pelaporan_pddikti_id')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="">
                        <div class="flex sm:flex-row xs:flex-col sm:space-x-2 w-full sm:space-y-0 xs:space-y-4">
                            <div class="sm:w-[50%] xs:w-full space-y-2">
                                <label class="block sm:text-lg xs:text-[10px] text-primary-white"
                                    for="designer">Project Asisten Dosen <span
                                        class="bg-blue-100 ml-1 text-blue-600 px-2 py-1 rounded-full text-[8px] font-semibold">Optional</span></label>
                                <select name="asisten_id"
                                    class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                                    id="designer">
                                    <option value="">Select Asisten Dosen</option>
                                    @foreach ($employees->where('role.name', 'Asisten DOSEN') as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('asisten_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('asisten_id')
                                    <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="sm:w-[50%] xs:w-full space-y-2">
                                <label class="block sm:text-lg xs:text-[10px] text-primary-white"
                                    for="engineer_web">Jaringan Instalasi <span
                                        class="bg-blue-100 ml-1 text-blue-600 px-2 py-1 rounded-full text-[8px] font-semibold">Optional</span></label>
                                <select name="jaringan_instalasi_id"
                                    class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                                    id="engineer_web">
                                    <option value="">Select Jaringan Instalasi</option>
                                    @foreach ($employees->where('role.name', 'Jaringan Dan Instalasi') as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('jaringan_instalasi_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('jaringan_instalasi_id')
                                    <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex sm:flex-row xs:flex-col sm:space-x-2 sm:space-y-0 xs:space-y-4">
                            <div class="sm:w-[50%] xs:w-full space-y-2">
                                <label class="block sm:text-lg xs:text-[10px] text-primary-white"
                                    for="engineer_mobile">Teknisi <span
                                        class="bg-blue-100 ml-1 text-blue-600 px-2 py-1 rounded-full text-[8px] font-semibold">Optional</span></label>
                                <select
                                    name="teknisi_id" class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                                    id="engineer_mobile">
                                    <option value="">Select teknisi</option>
                                    @foreach ($employees->where('role.name', 'TEKNISI') as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('teknisi_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('teknisi_id')
                                    <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-2 sm:w-[50%] xs:w-full">
                                <label class="block sm:text-lg xs:text-[10px] text-primary-white"
                                    for="engineer_tester">Pengelola Sosial Media <span
                                        class="bg-blue-100 ml-1 text-blue-600 px-2 py-1 rounded-full text-[8px] font-semibold">Optional</span></label>
                                <select name="pengelola_sosmed_id"
                                    class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                                    id="engineer_tester">
                                    <option value="">Select pengelola sosmed</option>
                                    @foreach ($employees->where('role.name', 'Pengelola Sosial Media') as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('pengelola_sosmed_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('pengelola_sosmed_id')
                                    <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                </div>
                {{-- mobile --}}
                <div
                    class="sm:fixed xs:absolute sm:bottom-4 xs:bottom-3 sm:right-4 xs:right-3 sm:hidden xs:flex space-x-4">
                    <a href="{{ url()->previous() }}"
                        class="bg-white text-black border border-black sm:text-xs xs:text-[11px] sm:px-4 sm:py-2 xs:px-3 xs:py-1 rounded-md hover:bg-gray-100">Cancel</a>
                    <button type="submit"
                        class="bg-black text-white sm:text-xs xs:text-[11px] sm:px-4 sm:py-2 xs:px-3 xs:py-1 rounded-md">Create</button>
                </div>
            </div>
            {{-- desktop --}}
            <div class="fixed bottom-4 right-4 sm:flex xs:hidden space-x-4">
                <a href="{{ url()->previous() }}"
                    class="bg-white text-black border border-black px-12 py-1 rounded-md hover:bg-gray-100">Cancel</a>
                <button type="submit" class="bg-black text-white px-12 py-1 rounded-md">Create</button>
            </div>
        </form>
    </main>

    <style>

    </style>
    <script>
        const form = document.getElementById('create_project');

        document.addEventListener('DOMContentLoaded', () => {
            // Load data from local storage on page load
            Object.keys(localStorage).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.value = localStorage.getItem(key);
                }
            });
        });

        form.addEventListener('input', (event) => {
            const {
                id,
                value
            } = event.target;

            if (id) {
                localStorage.setItem(id, value);
            }
        });

        form.addEventListener('submit', (e) => {
            localStorage.clear();
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

        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi pengecekan untuk grup date (start & end)
            function toggleDateLabel() {
                const start = document.getElementById('start_date');
                const end = document.getElementById('end_date');
                const dateLabel = document.querySelector('span[data-required-label="date"]');

                if (!dateLabel || !start || !end) return;

                if (start.value.trim() !== '' && end.value.trim() !== '') {
                    dateLabel.style.display = 'none';
                } else {
                    dateLabel.style.display = '';
                }
            }

            // Jalankan saat halaman dimuat
            toggleDateLabel();

            // Tambahkan event listener ke kedua input
            document.getElementById('start_date').addEventListener('input', toggleDateLabel);
            document.getElementById('end_date').addEventListener('input', toggleDateLabel);

            // — Kamu bisa lanjutkan juga untuk field lain seperti sebelumnya —
        });

        let inputCounter = 0;
        let selectedSDM = [];
        let searchTimeout;



        // CSRF Token untuk Laravel
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        function addInput() {
            inputCounter++;
            const container = document.getElementById('sdm-inputs-container');

            const inputGroup = document.createElement('div');
            inputGroup.className = 'relative';
            inputGroup.id = `input-group-${inputCounter}`;

            inputGroup.innerHTML = `
        <div class="flex items-center space-x-2">
            <div class="flex-1 relative">
                <input 
                    type="text" 
                    id="sdm-input-${inputCounter}"
                    name="sdm_search[]"
                    placeholder="Ketik nama SDM..." 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm xs:text-[12px]"
                    oninput="handleSearch(${inputCounter}, this.value)"
                    onfocus="showDropdown(${inputCounter})"
                    onblur="hideDropdown(${inputCounter})"
                    onkeydown="handleKeydown(${inputCounter}, event)"
                    autocomplete="off"
                >
                <input type="hidden" name="sdm_ids[]" id="sdm-id-${inputCounter}" value="">
                
                <!-- Loading indicator -->
                <div id="loading-${inputCounter}" class="absolute right-3 top-3 hidden">
                    <div class="loading-spinner"></div>
                </div>
                
                <!-- Dropdown untuk hasil autocomplete -->
                <div id="dropdown-${inputCounter}" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 hidden autocomplete-dropdown">
                    <div id="dropdown-content-${inputCounter}" class="py-1">
                        <!-- Results will be populated here -->
                    </div>
                </div>
            </div>
            
            <button 
                type="button" 
                onclick="removeInput(${inputCounter})"
                class="bg-red-500 hover:bg-red-600 text-white sm:px-3 sm:py-2 xs:px-2 xs:py-2 rounded-md transition-colors sm:text-sm xs:text-[10px] flex-shrink-0"
            >
                Hapus
            </button>
        </div>
    `;

            container.appendChild(inputGroup);
            document.getElementById(`sdm-input-${inputCounter}`).focus();
        }

        function removeInput(id) {
            const inputGroup = document.getElementById(`input-group-${id}`);
            if (inputGroup) {
                const hiddenInput = document.getElementById(`sdm-id-${id}`);
                if (hiddenInput && hiddenInput.value) {
                    selectedSDM = selectedSDM.filter(sdm => sdm.id != hiddenInput.value);
                }
                inputGroup.remove();
            }
        }

        console.log(selectedSDM);

        function handleSearch(inputId, query) {
            const dropdown = document.getElementById(`dropdown-${inputId}`);
            const dropdownContent = document.getElementById(`dropdown-content-${inputId}`);
            const loading = document.getElementById(`loading-${inputId}`);

            // Clear previous timeout
            clearTimeout(searchTimeout);

            if (query.length < 1) {
                dropdown.classList.add('hidden');
                loading.classList.add('hidden');
                return;
            }

            // Show loading
            loading.classList.remove('hidden');

            // Debounce search
            searchTimeout = setTimeout(() => {
                const searchUrl = '/projects/search-sdm'; // Make sure this matches your route

                fetch(searchUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            query: query
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        loading.classList.add('hidden');

                        // Filter out already selected SDM
                        const availableSDM = data.filter(sdm =>
                            !selectedSDM.some(selected => selected.id === sdm.id)
                        );

                        if (availableSDM.length > 0) {
                            dropdownContent.innerHTML = availableSDM.map((sdm, index) => `
                        <div 
                            class="autocomplete-item px-4 py-2 cursor-pointer border-b border-gray-100 last:border-b-0 hover:bg-gray-50" 
                            data-index="${index}"
                            onmousedown="selectSDM(${inputId}, '${sdm.id}', '${sdm.name.replace(/'/g, "\\'")}', '${sdm.role.replace(/'/g, "\\'")}')"
                        >
                            <div class="font-medium text-gray-900 sm:text-sm xs:text-[12px]">${sdm.name}</div>
                            <div class="text-sm text-gray-600 xs:text-[11px]">${sdm.role} • ${sdm.email}</div>
                        </div>
                    `).join('');
                            dropdown.classList.remove('hidden');
                        } else {
                            dropdownContent.innerHTML = `
                        <div class="px-4 py-2 text-gray-500 sm:text-sm xs:text-[12px]">
                            ${query.length > 0 ? 'Tidak ada SDM dengan nama tersebut atau sudah dipilih' : 'Ketik nama untuk mencari SDM'}
                        </div>
                    `;
                            dropdown.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        loading.classList.add('hidden');
                        console.error('Error fetching SDM:', error);
                        dropdownContent.innerHTML = `
                    <div class="px-4 py-2 text-red-500 sm:text-sm xs:text-[12px]">
                        Terjadi kesalahan saat mencari SDM. Silakan coba lagi.
                    </div>
                `;
                        dropdown.classList.remove('hidden');
                    });
            }, 300); // 300ms debounce
        }

        function selectSDM(inputId, sdmId, sdmName, sdmRole) {
            const input = document.getElementById(`sdm-input-${inputId}`);
            const hiddenInput = document.getElementById(`sdm-id-${inputId}`);
            const dropdown = document.getElementById(`dropdown-${inputId}`);

            // Set input values
            input.value = `${sdmName} (${sdmRole})`;
            hiddenInput.value = sdmId;

            // Add to selected SDM
            if (!selectedSDM.some(selected => selected.id === parseInt(sdmId))) {
                selectedSDM.push({
                    id: parseInt(sdmId),
                    name: sdmName,
                    role: sdmRole
                });
            }

            // Hide dropdown and make input readonly
            dropdown.classList.add('hidden');
            input.classList.add('bg-gray-100', 'cursor-not-allowed');
            input.readOnly = true;

            // Add a reset button functionality
            const inputGroup = document.getElementById(`input-group-${inputId}`);
            const existingResetBtn = inputGroup.querySelector('.reset-btn');
            if (!existingResetBtn) {
                const resetBtn = document.createElement('button');
                resetBtn.type = 'button';
                resetBtn.className = 'reset-btn absolute right-3 top-2 text-gray-500 hover:text-gray-700 p-1';
                resetBtn.innerHTML = `
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
            </svg>
        `;
                resetBtn.onclick = () => resetInput(inputId);
                resetBtn.title = 'Hapus pilihan SDM';

                const inputContainer = inputGroup.querySelector('.flex-1.relative');
                inputContainer.appendChild(resetBtn);
            }
        }

        function resetInput(inputId) {
            const input = document.getElementById(`sdm-input-${inputId}`);
            const hiddenInput = document.getElementById(`sdm-id-${inputId}`);
            const inputGroup = document.getElementById(`input-group-${inputId}`);
            const resetBtn = inputGroup.querySelector('.reset-btn');

            // Remove from selected SDM
            if (hiddenInput.value) {
                selectedSDM = selectedSDM.filter(sdm => sdm.id != parseInt(hiddenInput.value));
            }

            // Reset input
            input.value = '';
            input.readOnly = false;
            input.classList.remove('bg-gray-100', 'cursor-not-allowed');
            hiddenInput.value = '';

            // Remove reset button
            if (resetBtn) {
                resetBtn.remove();
            }

            // Focus input
            input.focus();
        }

        function showDropdown(inputId) {
            const input = document.getElementById(`sdm-input-${inputId}`);
            const dropdown = document.getElementById(`dropdown-${inputId}`);

            if (!input.readOnly && input.value.length > 0) {
                handleSearch(inputId, input.value);
            }
        }

        function hideDropdown(inputId) {
            setTimeout(() => {
                const dropdown = document.getElementById(`dropdown-${inputId}`);
                if (dropdown) {
                    dropdown.classList.add('hidden');
                }
            }, 150);
        }

        function handleKeydown(inputId, event) {
            const input = document.getElementById(`sdm-input-${inputId}`);

            // Don't handle keydown if input is readonly
            if (input.readOnly) {
                return;
            }

            const dropdown = document.getElementById(`dropdown-${inputId}`);
            const items = dropdown.querySelectorAll('.autocomplete-item');

            if (items.length === 0) return;

            let selectedIndex = -1;
            items.forEach((item, index) => {
                if (item.classList.contains('selected')) {
                    selectedIndex = index;
                }
            });

            switch (event.key) {
                case 'ArrowDown':
                    event.preventDefault();
                    selectedIndex = selectedIndex < items.length - 1 ? selectedIndex + 1 : 0;
                    updateSelection(items, selectedIndex);
                    break;

                case 'ArrowUp':
                    event.preventDefault();
                    selectedIndex = selectedIndex > 0 ? selectedIndex - 1 : items.length - 1;
                    updateSelection(items, selectedIndex);
                    break;

                case 'Enter':
                    event.preventDefault();
                    if (selectedIndex >= 0) {
                        items[selectedIndex].click();
                    }
                    break;

                case 'Escape':
                    dropdown.classList.add('hidden');
                    break;
            }
        }

        function updateSelection(items, selectedIndex) {
            items.forEach((item, index) => {
                if (index === selectedIndex) {
                    item.classList.add('selected');
                } else {
                    item.classList.remove('selected');
                }
            });
        }
    </script>
</x-layouts.layout>
