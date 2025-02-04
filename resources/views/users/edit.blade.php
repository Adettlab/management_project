<x-layouts.layout :title="$title" :active="$active">
    <main class="flex-1 p-6 bg-white shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Edit User</h1>
        <form action="{{ route('users.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Work Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="work_email">Work Email</label>
                <input type="email" name="work_email" id="work_email"
                    class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                    value="{{ old('work_email', $employee->work_email) }}" required>
                @error('work_email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Upload Photo -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="photo">Upload Photo</label>
                <input type="file" name="photo" id="photo"
                    class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md">
                @if ($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" alt="Photo" class="mt-2 w-32 z-10">
                @endif
                @error('photo')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- NIK -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="nik">NIK</label>
                <input type="text" name="nik" id="nik"
                    class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                    value="{{ old('nik', $employee->nik) }}">
                @error('nik')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Status SDM -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="status">Status SDM</label>
                <select name="status" id="status"
                    class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md">
                    <option value="">Select status</option>
                    @foreach (['Kontrak', 'Freelance', 'Tetap', 'Tenaga Ahli'] as $status)
                        <option value="{{ $status }}"
                            {{ old('status', $employee->status) === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Birth Date -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="birth_date">Birth Date</label>
                <input type="date" name="birth_date" id="birth_date"
                    class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                    value="{{ old('birth_date', $employee->birth_date) }}">
                @error('birth_date')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number"
                    class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                    value="{{ old('phone_number', $employee->phone_number) }}">
                @error('phone_number')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Telegram Link -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="telegram_link">Telegram Link</label>
                <input type="text" name="telegram_link" id="telegram_link"
                    class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                    value="{{ old('telegram_link', $employee->telegram_link) }}">
                @error('telegram_link')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Address -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="address">Address</label>
                <textarea name="address" id="address"
                    class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md">{{ old('address', $employee->address) }}</textarea>
                @error('address')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Join Date -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="join_date">Join Date</label>
                <input type="date" name="join_date" id="join_date"
                    class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                    value="{{ old('join_date', $employee->join_date) }}">
                @error('join_date')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Education -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="education">Education</label>
                <input type="text" name="education" id="education"
                    class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                    value="{{ old('education', $employee->education) }}">
                @error('education')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('users.index') }}"
                    class="px-4 py-2 text-gray-800 bg-gray-200 rounded-md hover:bg-gray-300">Cancel</a>
                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Update</button>
            </div>
        </form>
    </main>
</x-layouts.layout>
