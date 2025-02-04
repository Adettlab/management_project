<x-layouts.layout :title="$title" :active="$active">
    <!-- Main Content Area -->
    <main class="flex-1 p-6 h-screen">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">users</h1>
            {{-- @auth
                @if (auth()->user()->role === 'admin') --}}
            <a href="{{ route('admin.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">New User</a>
            {{-- @endif
            @endauth --}}
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="flex justify-between items-center mb-4">
                <div class="ml-auto flex items-center">
                    <form method=" class="flex mb-4">
                        <input type="text" name="search" class="border border-gray-300 rounded-md px-4 py-2"
                            placeholder="Search tasks..." value="{{ request('search') }}">
                        <button type="submit" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 ml-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.9 14.32a8 8 0 111.41-1.41l4.78 4.78a1 1 0 01-1.42 1.42l-4.78-4.78zM14 8a6 6 0 11-12 0 6 6 0 0112 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <table class="w-full table-auto">
                <thead>
                    <tr class="text-left text-gray-600">
                        <th class="py-2">Username</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">Divisi</th>
                        <th class="py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr class="border-t">
                            <td class="py-2">{{ $employee->user->name ?? 'No username' }}</td>
                            <td class="py-2">{{ $employee->user->email ?? 'No email' }}</td>
                            <td class="py-2">{{ $employee->role->name ?? 'No role' }}</td>
                            
                            <td class="py-2 flex space-x-2 items-center justify-center">
                                <a href=""
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 rounded-full">view</a>
                            </td>
                            <td class="py-2 flex space-x-2 items-center justify-center">
                                <a href="{{ route('users.edit', $employee->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 rounded-full">Edit</a>
                            </td>
                            <td>
                                <form action="{{ route('admin.destroy', $employee->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 rounded-full">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- <div class="mt-4 flex justify-between items-center">
                <p class="text-gray-600">Showing 1 to {{ count($tasks) }} of {{ count($tasks) }} results</p>
            </div> --}}
        </div>
    </main>
</x-layouts.layout>

