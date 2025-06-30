<x-layouts.layout :title="$title" :active="$active">
    <div class="sm:mx-32 xs:mx-5">
        <div
            class="bg-white rounded-lg border-2 sm:shadow-none xs:shadow-[0_0_0_0.5px_rgba(0,0,0,0.15)] border-gray-200 px-6 sm:py-3 xs:py-5 max-w-full w-full mx-auto">
            <div class="flex flex-row items-center justify-between mb-2">
                <h1 class="sm:text-2xl xs:text-[16px] font-bold">Leave Submission</h1>
                @if ($errors->has('error'))
                    <div class="flex bg-red-100 rounded-lg p-2 sm:text-xs xs:text-[11px] text-red-700" role="alert">
                        <svg class="w-4 h-4 inline mr-3" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            Something went wrong. Please try again or contact support
                        </div>
                    </div>
                @endif
            </div>
            <form action="{{ route('administration.store') }}" method="POST" enctype="multipart/form-data"
                id="administrationForm" class="sm:mt-0 xs:mt-4">
                @csrf
                <div class="space-y-4">
                    <!-- Leave Category -->
                    <div class="flex flex-col relative space-y-2">
                        <label class="block sm:text-sm xs:text-[10px] text-gray-700 font-semibold">Leave
                            Category</label>
                        <div class="relative z-20">
                            <button id="dropdown-button-leaves"
                                class="inline-flex items-center w-full px-3 py-2 sm:text-sm xs:text-[12px] bg-primary-white border border-primary-white rounded-md shadow-sm"
                                type="button" onclick="toggleCategoryDropdown(event)">
                                <span class="mr-auto"
                                    id="leaves-display">{{ old('leave_category_id') ? $categories->find(old('leave_category_id'))->name : 'Leave category' }}</span>
                                <svg id="categories-icon"
                                    class="w-5 h-5 ml-2 transform transition-transform duration-500" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div id="categories-dropdown"
                                class="absolute left-0 right-0 w-full mt-1 bg-primary-white border rounded-md shadow-lg p-1 space-y-1 transform opacity-0 scale-95 -translate-y-2 hidden transition-all duration-300 ease-out origin-top z-50">
                                @foreach ($categories as $category)
                                    <div class="block px-4 py-1 text-black hover:bg-[#C3C3C3] cursor-pointer rounded-md sm:text-sm xs:text-[12px]"
                                        onclick="selectCategory({{ $category->id }}, '{{ $category->name }}')">
                                        {{ $category->name }}
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="leave_category_id" id="leave_category_id_input"
                                value="{{ old('leave_category_id') }}">
                        </div>
                    </div>

                    <!-- Date Inputs -->
                    <div class="flex flex-col">
                        <label class="sm:text-sm xs:text-[10px] font-semibold text-gray-700 mb-1">Date</label>
                        <div class="flex gap-4">
                            <div class="w-1/2">
                                <label for="start_date" class="sm:text-sm xs:text-[10px] text-gray-700">Start:</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="w-full border px-3 py-2 sm:text-sm xs:text-[12px] rounded-md focus:outline-none"
                                    required value="{{ old('start_date') }}" onchange="printDay()">
                                @error('start_date')
                                    <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-1/2">
                                <label for="end_date" class="sm:text-sm xs:text-[10px] text-gray-700">End:</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="w-full border px-3 py-2 sm:text-sm xs:text-[12px] rounded-md focus:outline-none"
                                    required value="{{ old('end_date') }}" onchange="printDay()">
                                @error('end_date')
                                    <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Lama Cuti -->
                    <div class="flex flex-col">
                        <label class="sm:text-sm xs:text-[10px] font-semibold text-gray-700 mb-1"
                            for="lama_hari_cuti">Lama Cuti</label>
                        <input type="text" name="lama_hari_cuti" id="lama_hari_cuti" placeholder="Jumlah Hari Cuti.."
                            class="border px-4 py-2 sm:text-sm xs:text-[12px] rounded-md focus:outline-none"
                            value="{{ old('lama_hari_cuti') }}" @readonly(true)>
                        @error('lama_hari_cuti')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="flex flex-col">
                        <label class="sm:text-sm xs:text-[10px] font-semibold text-gray-700 mb-1"
                            for="description">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="border px-4 py-2 sm:text-sm xs:text-[12px] rounded-md focus:outline-none"
                            placeholder="Submission Description...">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-red-600 sm:text-sm xs:text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Radio Option -->
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="sm:text-sm xs:text-[10px] font-semibold text-gray-700">Bring Laptop?</label>
                            <div class="flex border p-2 rounded-md bg-white space-x-4">
                                <label class="flex items-center sm:text-sm xs:text-[10px] text-gray-700">
                                    <input type="radio" name="bring_laptop"
                                        class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none"
                                        value="0" {{ old('bring_laptop') == '0' ? 'checked' : '' }}> No
                                </label>
                                <label class="flex items-center sm:text-sm xs:text-[10px] text-gray-700">
                                    <input type="radio" name="bring_laptop"
                                        class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none"
                                        value="1" {{ old('bring_laptop') == '1' ? 'checked' : '' }}> Yes
                                </label>
                            </div>
                        </div>
                        <div class="w-1/2">
                            <label class="sm:text-sm xs:text-[10px] font-semibold text-gray-700">Can be
                                Contacted?</label>
                            <div class="flex border p-2 rounded-md bg-white space-x-4">
                                <label class="flex items-center sm:text-sm xs:text-[10px] text-gray-700">
                                    <input type="radio" name="contacted"
                                        class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none"
                                        value="0" {{ old('contacted') == '0' ? 'checked' : '' }}> No
                                </label>
                                <label class="flex items-center sm:text-sm xs:text-[10px] text-gray-700">
                                    <input type="radio" name="contacted"
                                        class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none"
                                        value="1" {{ old('contacted') == '1' ? 'checked' : '' }}> Yes
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-center space-x-4 pt-2 sm:text-sm xs:text-[12px]">
                        <a href="{{ url()->previous() }}"
                            class="bg-gray-100 text-black border border-gray-300 px-6 py-2 rounded-md hover:bg-gray-200">Cancel</a>
                        <button type="submit"
                            class="bg-black text-white px-6 py-2 rounded-md hover:bg-gray-800">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        const day = document.getElementById('lama_hari_cuti');

        function printDay() {
            if (startDate.value && endDate.value) {
                const start = new Date(startDate.value);
                const end = new Date(endDate.value);

                if (end < start) {
                    day.value = "End date must be after start date";
                    day.classList.add("border-red-500");
                    return;
                }

                const diffTime = end - start;
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

                day.classList.remove("border-red-500");
                day.value = diffDays + (diffDays === 1 ? " day" : " days");
            } else {
                day.value = "Please select both dates";
            }
        }

        function toggleCategoryDropdown(event) {
            event.preventDefault();
            const dropdown = document.getElementById('categories-dropdown');
            const icon = document.getElementById('categories-icon');

            if (dropdown.classList.contains('hidden')) {

                dropdown.classList.remove('hidden');
                setTimeout(() => {
                    dropdown.classList.remove('opacity-0', 'scale-95', '-translate-y-2');
                    dropdown.classList.add('opacity-100', 'scale-100', 'translate-y-0');
                    icon.classList.add('rotate-180');
                }, 10);
            } else {
                dropdown.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
                dropdown.classList.add('opacity-0', 'scale-95', '-translate-y-2');
                icon.classList.remove('rotate-180');
                setTimeout(() => {
                    dropdown.classList.add('hidden');
                }, 300);
            }
        }

        function selectCategory(id, name) {
            document.getElementById('leaves-display').textContent = name;
            document.getElementById('leave_category_id_input').value = id;
            const dropdown = document.getElementById('categories-dropdown');
            const icon = document.getElementById('categories-icon');

            dropdown.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
            dropdown.classList.add('opacity-0', 'scale-95', '-translate-y-2');
            icon.classList.remove('rotate-180');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 300);
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('categories-dropdown');
            const button = document.getElementById('dropdown-button-leaves');

            if (!dropdown.contains(event.target) && !button.contains(event.target) && !dropdown.classList.contains(
                    'hidden')) {
                const icon = document.getElementById('categories-icon');
                dropdown.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
                dropdown.classList.add('opacity-0', 'scale-95', '-translate-y-2');
                icon.classList.remove('rotate-180');

                setTimeout(() => {
                    dropdown.classList.add('hidden');
                }, 300);
            }
        });
    </script>
</x-layouts.layout>
