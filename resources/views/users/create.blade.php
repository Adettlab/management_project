<x-layouts.layout :title="$title" :active="$active">
    <main class="flex-1 p-6 bg-white shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Create User</h1>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <!-- User Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Username Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="username">Username</label>
                    <input type="text" name="name" id="username"
                        class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                        placeholder="Enter username..." value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                    <input type="email" name="email" id="email"
                        class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                        placeholder="Enter email address..." value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Role Selection -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="role_id">Division</label>
                <select name="role_id" id="role_id"
                    class="mt-1 py-1 px-2 block w-full text-sm border border-gray-300 rounded-md" required>
                    <option value="">Select division</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Password Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                        placeholder="Enter password..." required>
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                        placeholder="Confirm password..." required>
                    @error('password_confirmation')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Form Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ url()->previous() }}"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Create</button>
            </div>
        </form>
    </main>
</x-layouts.layout>
