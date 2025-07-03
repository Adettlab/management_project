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
                        <label class="block sm:text-lg xs:text-[10px] text-primary-white" for="director">Project
                            Director <span
                                class="bg-red-100 ml-1 text-red-600 px-2 py-1 rounded-full text-[8px] font-semibold"
                                data-required-label="director">Required</span></label>
                        <select name="director_id"
                            class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                            id="director" required>
                            <option value="">Select project director</option>
                            @foreach ($employees->where('role.name', 'Project Director') as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ old('director_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->user->name }}</option>
                            @endforeach
                        </select>
                        @error('director_id')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col space-y-2">
                        <label class="block sm:text-lg xs:text-[10px] text-primary-white" for="analyst">Project
                            Analyst <span
                                class="bg-blue-100 ml-1 text-blue-600 px-2 py-1 rounded-full text-[8px] font-semibold">Optional</span></label>
                        <select name="analyst_id"
                            class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                            id="analyst">
                            <option value="">Select project analyst</option>
                            @foreach ($employees->where('role.name', 'Analyst') as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ old('analyst_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->user->name }}</option>
                            @endforeach
                        </select>
                        @error('analyst_id')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="">
                        <div class="flex sm:flex-row xs:flex-col sm:space-x-2 w-full sm:space-y-0 xs:space-y-4">
                            <div class="sm:w-[50%] xs:w-full space-y-2">
                                <label class="block sm:text-lg xs:text-[10px] text-primary-white"
                                    for="designer">Project Designer <span
                                        class="bg-blue-100 ml-1 text-blue-600 px-2 py-1 rounded-full text-[8px] font-semibold">Optional</span></label>
                                <select name="designer_id"
                                    class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                                    id="designer">
                                    <option value="">Select project designer</option>
                                    @foreach ($employees->where('role.name', 'Designer') as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('designer_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('designer_id')
                                    <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="sm:w-[50%] xs:w-full space-y-2">
                                <label class="block sm:text-lg xs:text-[10px] text-primary-white"
                                    for="engineer_web">Engineer Web <span
                                        class="bg-blue-100 ml-1 text-blue-600 px-2 py-1 rounded-full text-[8px] font-semibold">Optional</span></label>
                                <select name="engineer_web_id"
                                    class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                                    id="engineer_web">
                                    <option value="">Select engineer web</option>
                                    @foreach ($employees->where('role.name', 'Engineer Web') as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('engineer_web_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('engineer_web_id')
                                    <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex sm:flex-row xs:flex-col sm:space-x-2 sm:space-y-0 xs:space-y-4">
                            <div class="sm:w-[50%] xs:w-full space-y-2">
                                <label class="block sm:text-lg xs:text-[10px] text-primary-white"
                                    for="engineer_mobile">Engineer Mobile <span
                                        class="bg-blue-100 ml-1 text-blue-600 px-2 py-1 rounded-full text-[8px] font-semibold">Optional</span></label>
                                <select
                                    name="engineer_mobile_id"class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                                    id="engineer_mobile">
                                    <option value="">Select engineer mobile</option>
                                    @foreach ($employees->where('role.name', 'Engineer Mobile') as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('engineer_mobile_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('engineer_mobile_id')
                                    <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-2 sm:w-[50%] xs:w-full">
                                <label class="block sm:text-lg xs:text-[10px] text-primary-white"
                                    for="engineer_tester">Engineer Tester <span
                                        class="bg-blue-100 ml-1 text-blue-600 px-2 py-1 rounded-full text-[8px] font-semibold">Optional</span></label>
                                <select name="engineer_tester_id"
                                    class="w-full bg-primary-white border border-primary-white px-3 py-2 sm:text-sm xs:text-[12px] rounded focus:outline-none"
                                    id="engineer_tester">
                                    <option value="">Select engineer tester</option>
                                    @foreach ($employees->where('role.name', 'Engineer Tester') as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('engineer_tester_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('engineer_tester_id')
                                    <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
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
    </script>
</x-layouts.layout>
