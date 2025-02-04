<x-layouts.layout :title="$title" :active="$active">
    <main class="flex flex-col items-center justify-center">
        <div class="bg-white w-[60%] py-9 px-12 rounded-xl border border-gray-200">
            <form action="{{ route('admin.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex items-center">
                    <div id="image-preview" class="w-24 h-24 bg-zinc-200 rounded-full flex items-center justify-center overflow-hidden">
                        @if ($employee->photo)
                            <img src="{{ asset('/storage/' . $employee->photo) }}" alt="Uploaded Picture" class="w-full h-full object-cover">
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
                                <input id="photo" name="photo" id="photo" type="file" accept="image/*"
                                    class="hidden" />
                            </div>
                            <button id="delete-button"
                                class="bg-secondary-white text-[#7D7D7D] px-4 py-1 text-xs rounded font-medium">Deleted
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

                    <!-- Password Input -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="password" class="primary-gray font-medium text-sm">Password</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Enter password" type="text" id="password" name="password">
                        @error('password')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex mt-3 w-full">

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

                    <!-- Telegram input -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="telegram_link" class="primary-gray font-medium text-sm">Link
                            Telegram</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Enter link telegram" type="text" name="telegram_link" id="telegram_link"
                            value="{{ old('telegram_link', $employee->telegram_link) }}">
                        @error('telegram_link')
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
                            @foreach (['Kontrak', 'Freelance', 'Tetap', 'Tenaga Ahli'] as $status)
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
                </div>
                <div class="flex mt-3 w-full">

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

                    <!-- Birth Date -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="birth_date" class="primary-gray font-medium text-sm">Tanggal
                            Lahir</label>
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

                    <!-- Education terakhir -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="education" class="primary-gray font-medium text-sm">Pendidikan
                            Terakhir</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Enter education" type="text" name="education" id="education"
                            value="{{ old('education', $employee->education) }}">
                        @error('education')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-9 flex justify-center">
                    <button type="submit"
                        class="bg-primary-black hover:bg-zinc-500 text-white text-sm px-10 py-1 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </main>
</x-layouts.layout>

<script>
    const fileInput = document.getElementById('photo');
    const imagePreview = document.getElementById('image-preview');
    const deleteButton = document.getElementById('delete-button');

    // Fungsi untuk upload gambar
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
        // Mencegah submit form dan refresh halaman
        event.preventDefault();

        // Reset preview ke kondisi awal
        imagePreview.innerHTML = `<span class="text-gray-400 text-sm">Preview</span>`;

        // Reset input file
        fileInput.value = ''; // Membersihkan file yang terpilih
    });
</script>
