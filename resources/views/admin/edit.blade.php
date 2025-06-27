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
                            <h1 class="font-semibold text-xl">{{ $employee->user->name ?? 'No username' }}</h1>
                            <p class="tex-xs">{{ $employee->role->name ?? 'No devisi' }}</p>
                        </div>
                        <div class="flex mt-2">
                            <div class="ml-5 mr-3">
                                <label for="photo"
                                    class="cursor-pointer bg-sky-blue text-white text-xs font-medium px-4 py-1 rounded hover:bg-blue-600">
                                    Upload Picture
                                </label>
                                <input id="photo" name="photo" type="file" accept="image/*" class="hidden" />
                            </div>
                            <button id="delete-button"
                                class="bg-secondary-white text-[#7D7D7D] px-4 py-1 text-xs rounded font-medium">Delete
                                Picture
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex mt-10 w-full">
                    <!-- Work Email Input -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="work_email" class="primary-gray font-medium text-sm">Email Company</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Enter email" type="email" name="work_email" id="work_email"
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
                            placeholder="Enter NIK" type="text" name="nik" id="nik"
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
                            <option value="">Select status</option>
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
                            placeholder="Enter no. hp" type="text" name="phone_number" id="phone_number"
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
                            placeholder="Enter address" type="text" name="address" id="address"
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
                            placeholder="Enter education" type="text" name="education" id="education"
                            value="{{ old('education', $employee->education) }}">
                        @error('education')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Custom Permissions Section - SELALU TAMPIL UNTUK SEMUA USER -->
                <div class="mt-6 border-t pt-4">
                    <h3 class="primary-gray font-medium text-sm mb-3">Permissions</h3>

                    @if ($hasCustomPermissions)
                        <p class="text-xs text-green-600 mb-3">✓ User ini menggunakan custom permissions</p>
                    @else
                        <p class="text-xs text-blue-600 mb-3">ℹ User ini menggunakan default role permissions
                            ({{ $employee->role->name ?? 'No Role' }})</p>
                        <p class="text-xs text-orange-600 mb-3">💡 Centang checkbox di bawah untuk menambahkan custom
                            permissions</p>
                    @endif

                    <div class="space-y-3">
                        @foreach ($pages as $page)
                            @php
                                $permission = $userPermissions[$page->id] ?? null;
                            @endphp
                            <div class="border border-gray-300 rounded-lg p-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-sm capitalize">{{ $page->name }}</span>
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
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        @if ($hasCustomPermissions)
                            Kosongkan semua untuk kembali menggunakan default role permissions.
                        @else
                            Centang checkbox untuk menambahkan custom permissions. Kosongkan semua untuk tetap
                            menggunakan default role permissions.
                        @endif
                    </p>
                </div>

                <div class="mt-9 flex justify-center">
                    <button type="submit"
                        class="bg-primary-black hover:bg-zinc-500 text-white text-sm px-10 py-1 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const fileInput = document.getElementById('photo');
        const imagePreview = document.getElementById('image-preview');
        const deleteButton = document.getElementById('delete-button');

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.innerHTML =
                        `<img src="${e.target.result}" alt="Uploaded Picture" class="w-full h-full object-cover">`;
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.innerHTML = `<span class="text-gray-400 text-sm">Preview</span>`;
            }
        });

        deleteButton.addEventListener('click', (event) => {
            event.preventDefault();
            imagePreview.innerHTML = `<span class="text-gray-400 text-sm">Preview</span>`;
            fileInput.value = '';
        });
    </script>
</x-layouts.layout>
