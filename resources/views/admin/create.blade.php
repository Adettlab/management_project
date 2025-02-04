<x-layouts.layout :title="$title" :active="$active">
    <main class="h-[500px] flex flex-col items-center justify-center">
        <div class="bg-white w-[60%] py-9 px-12 rounded-xl border border-gray-200">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <h1 class="font-semibold text-xl">Create New Account</h1>

                <div class="flex mt-10 w-full">

                    <!-- Username Input -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="username" class="primary-gray font-medium text-sm">Username</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Enter username" type="text" id="username" name="name"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="password" class="primary-gray font-medium text-sm">Password</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Enter password" type="text" id="password" name="password" required>
                        @error('password')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex mt-3 w-full">

                    <!-- Email Input -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="email" class="primary-gray font-medium text-sm">Email Akun</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Enter email" type="email" id="email" name="email"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="password_confirmation" class="primary-gray font-medium text-sm">Confirm
                            password</label>
                        <input
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            placeholder="Confirm password" type="text" id="password_confirmation"
                            name="password_confirmation" required>
                        @error('password_confirmation')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-3 w-full">
                    <!-- Role Selection -->
                    <div class="w-1/2 flex flex-col space-y-1">
                        <label for="role_id" class="primary-gray font-medium text-sm">Division</label>
                        <select name="role_id" id="role_id"
                            class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border border-gray-200 outline-none"
                            required>
                            <option value="">Enter division</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-9 mb-4 flex justify-center">
                    <button type="submit"
                        class="bg-primary-black hover:bg-zinc-500 text-white text-sm px-10 py-1 rounded-lg">Create
                        Account</button>
                </div>
            </form>
        </div>
    </main>
</x-layouts.layout>
