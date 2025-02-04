<x-layouts.layout :title="$title" :active="$active">
    <div class="mx-32 my-1">
        <div class="bg-white rounded-lg border-2 border-gray-200 p-6 max-w-full w-full mx-auto">
            <div class="flex flex-row items-center justify-between">
                <h1 class="text-2xl font-bold">Leave Submission</h1>
                @if ($errors->has('error'))
                    <div class="flex bg-red-100 rounded-lg p-2 text-xs text-red-700" role="alert">
                        <svg class="w-4 h-4 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            Something went wrong. Please try again or contact support
                        </div>
                    </div>
                @endif
            </div>
            <form action="{{ route('administration.store') }}" method="POST" enctype="multipart/form-data" id="create-form">
            @csrf
            <div class="mt-8 mx-2 space-y-5">
                <!-- Leave Category -->
                <div class="flex flex-col relative space-y-2">
                    <label class="block text-sm text-gray-500">Leave Category</label>
                    <button class="inline-flex items-center w-full px-3 py-1 text-sm bg-primary-white border border-primary-white rounded-md shadow-sm" type="button" onclick="dropdownOpenList()">
                        <span class="mr-auto" id="leaves-display">{{ old('leave_category_id') ? $categories->find(old('leave_category_id'))->name : 'Leave category' }}</span>                        <svg id="icon" class="w-5 h-5 ml-2 transform transition-transform duration-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <ul id="categories-dropdown"
                        class="w-ful right-0 mt-1 rounded-md shadow-lg bg-primary-white border p-1 space-y-1 transform opacity-0 scale-95 -translate-y-2 hidden transition-all duration-300 ease-out origin-top z-50">
                        @foreach ($categories as $category)
                            <li class="block px-4 py-1 text-black hover:bg-[#C3C3C3] cursor-pointer rounded-md"
                                onclick="listOnClick({{ $category->id }} , '{{ $category->name }}')">
                                {{ $category->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <input type="hidden" name="leave_category_id" id="leave_category_id" value="{{old('leave_category_id')}}">
                <!-- Date Inputs -->
                <div class="flex flex-col space-y-2">
                    <label class="block text-sm text-gray-500">Date</label>
                    <div class="flex items-center justify-between w-full gap-4">
                        <div class="flex items-center w-[50%] gap-2">
                            <label for="start_date" class="text-sm text-gray-500">Start:</label>
                            <input type="date" name="start_date" id="start_date" class="w-full bg-primary-white border border-primary-white px-3 py-2 text-sm rounded-md focus:outline-none" required value="{{ old('start_date') }}">
                            @error('start_date')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center w-[50%] gap-1">
                            <label for="end_date" class="text-sm text-gray-500">End:</label>
                            <input type="date" name="end_date" id="end_date" class="w-full bg-primary-white px-3 py-2 text-sm rounded-md focus:outline-none border border-primary-white" required value="{{ old('end_date') }}">
                            @error('end_date')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description Textarea -->
                <div class="flex flex-col space-y-2">
                    <label class="block text-sm text-gray-500" for="description">Description</label>
                    <textarea name="description" id="description" rows="4" placeholder="Leave Description" class="w-full bg-primary-white border border-primary-white px-3 py-2 text-sm rounded-md focus:outline-none">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Radio Option -->
                <div class="flex flex-row space-x-2">
                    <div class="flex flex-col w-[50%] space-y-1">
                        <label class="text-sm block text-gray-500">Do you bring your laptop? (if there is a supper urgent matter)</label>
                        <div class="flex space-x-4 items-center border py-2 px-3 bg-primary-white rounded-md">
                            <label class="flex items-center text-sm text-black">
                                <input type="radio" name="bring_laptop" class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="0" {{ old('bring_laptop') === '0' ? 'checked' : '' }} /> No
                            </label>
                            <label class="flex items-center text-sm text-black">
                                <input type="radio" name="bring_laptop" class="mr-2 accent-yellow-500 border-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="1" {{ old('bring_laptop') === '1' ? 'checked' : '' }} /> Yes
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-col w-[50%] space-y-1">
                        <label class="text-sm block text-gray-500">Do you still be contacted? (if there is a supper urgent matter)</label>
                        <div class="flex space-x-4 items-center border py-2 px-3 bg-primary-white rounded-md">
                            <label class="flex items-center text-sm text-black">
                                <input type="radio" name="contacted" class="mr-2 border-yellow-500 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="0" {{ old('contacted') === '0' ? 'checked' : '' }} /> No
                            </label>
                            <label class="flex items-center text-sm text-black">
                                <input type="radio" name="contacted" class="mr-2 accent-yellow-500 border-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="1" {{ old('contacted') === '1' ? 'checked' : '' }} /> Yes
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex mx-auto justify-center space-x-4 pt-4">
                    <a href="{{ url()->previous() }}" class="bg-white text-black border border-black px-16 py-1 rounded-md hover:bg-gray-100">Cancel</a>
                    <button type="submit" class="bg-black text-white px-16 py-1 rounded-md">Submit</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <script>
        const categories = document.getElementById('categories-dropdown');
        const icon = document.getElementById('icon');
        const leave = document.getElementById('leave_category_id');
        const display = document.getElementById('leaves-display');

        document.addEventListener('click', function(event) {
            const button = document.querySelector('button[onclick="dropdownOpenList()"]');
            const isClickInsideDropdown = categories.contains(event.target);
            const isClickOnButton = button.contains(event.target);

            if (!isClickInsideDropdown && !isClickOnButton) {
                categories.classList.add("hidden", "opacity-0", "scale-95", "-translate-y-2");
                icon.style.transform = "rotate(0deg)";
            }
        });

        function dropdownOpenList(){
            if (categories.classList.contains('hidden')){
                categories.classList.remove("hidden", "opacity-0", "scale-95", "-translate-y-2");
                icon.style.transform = "rotate(180deg)";
            }else{
                categories.classList.add("hidden", "opacity-0", "scale-95", "-translate-y-2");
                icon.style.transform = "rotate(0)";
            }
        }

        function listOnClick(id, name){
            display.innerHTML = name;
            leave.value = id;
            dropdownOpenList();
        }
    </script>
</x-layouts.layout>
