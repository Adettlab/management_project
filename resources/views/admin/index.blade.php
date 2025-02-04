<x-layouts.layout :title="$title" :active="$active">
    <main class="max-w-screen w-full mx-auto rounded-xl bg-white border">
        <!-- Search and Add Button -->
        <div class="flex items-center justify-between mb-2 pt-3 px-6">
            <form action="{{ route('admin.index') }}" method="GET" class="w-1/2 flex" id="filterForm">
                <div class="flex items-center w-[60%]">
                    <input type="text" placeholder="Search SDM"
                        class="border rounded-lg w-full pl-9 pr-4 py-1 focus:outline-none text-sm"
                        value="{{ request('search') }}" name="search" />
                    <svg class="size-5 ml-3 z-0 absolute" viewBox="0 0 41 41" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M19.5196 4C17.2041 4.0002 14.9222 4.55412 12.8644 5.61556C10.8065 6.677 9.0323 8.21517 7.68979 10.1017C6.34729 11.9883 5.47541 14.1686 5.14689 16.4607C4.81838 18.7527 5.04275 21.0901 5.8013 23.2778C6.55985 25.4655 7.83058 27.4401 9.50746 29.0369C11.1843 30.6336 13.2188 31.8062 15.441 32.4567C17.6632 33.1073 20.0088 33.217 22.282 32.7767C24.5552 32.3364 26.6902 31.3589 28.5088 29.9257L34.7477 36.1645C35.0699 36.4757 35.5014 36.6479 35.9493 36.644C36.3972 36.6401 36.8257 36.4604 37.1425 36.1437C37.4592 35.827 37.6389 35.3985 37.6427 34.9506C37.6466 34.5026 37.4744 34.0711 37.1633 33.7489L30.9244 27.5101C32.6123 25.3689 33.6632 22.7958 33.9569 20.0852C34.2506 17.3746 33.7753 14.6361 32.5853 12.1831C31.3953 9.73003 29.5388 7.66157 27.2281 6.2144C24.9175 4.76722 22.246 3.99982 19.5196 4ZM8.41543 18.5208C8.41543 15.5758 9.58533 12.7514 11.6678 10.669C13.7502 8.58657 16.5746 7.41667 19.5196 7.41667C22.4646 7.41667 25.289 8.58657 27.3714 10.669C29.4539 12.7514 30.6238 15.5758 30.6238 18.5208C30.6238 21.4658 29.4539 24.2902 27.3714 26.3727C25.289 28.4551 22.4646 29.625 19.5196 29.625C16.5746 29.625 13.7502 28.4551 11.6678 26.3727C9.58533 24.2902 8.41543 21.4658 8.41543 18.5208Z"
                            fill="#616161" fill-opacity="0.6" />
                    </svg>
                </div>
                <div class="ml-5 w-[40%]">
                    <select name="role"
                        class="w-[94%] primary-gray font-medium rounded-lg py-1 px-2 text-sm border outline-none"
                        id="roleFilter">
                        <option value="">Filter by division</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
            <a href="{{ route('admin.create') }}"
                class="bg-primary-black flex justify-center items-center hover:bg-zinc-500 cursor-pointer text-white text-xs px-4 py-1 rounded-lg hover:bg-gray-800">
                <svg class="size-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14m-7 7V5" />
                </svg>
                Add New SDM
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse ">
                <thead class="bg-[#F9F9F9]">
                    <tr>
                        <th class="w-[3%] pl-4 py-2 primary-gray text-left font-medium text-sm">No</th>
                        <th class="w-[10%] px-4 py-2 primary-gray text-left font-medium text-sm">Username</th>
                        <th class="w-[8%] px-4 py-2 primary-gray text-left font-medium text-sm">Divisi</th>
                        <th class="w-[3%] px-2 py-2 primary-gray text-left font-medium text-sm">Role</th>
                        <th class="w-[8%] px-4 py-2 primary-gray text-left font-medium text-sm">Email</th>
                        <th class="w-[6%] py-2 primary-gray text-left font-medium text-sm w-24">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Row -->
                    @foreach ($employees as $index => $employee)
                        <tr class="group hover:bg-[#F5F5F5] cursor-pointer font-medium" onclick="window.location='{{ route('admin.edit', $employee->id) }}'">
                            <td
                                class="pl-6 py-2 text-sm">
                                {{ $employees->firstItem() + $index }}
                            </td>
                            <td
                                class="px-4 py-2 text-sm">
                                {{ $employee->user->name ?? 'No username' }}
                            </td>
                            <td
                                class="px-2 py-2 text-sm">
                                {{ $employee->role->name ?? 'No devisi' }}
                            </td>
                            <td
                                class="px-4 py-2 text-sm">
                                {{ $employee->user->role ?? 'No role' }}
                            </td>
                            <td
                                class="px-4 py-2 text-sm">
                                {{ $employee->user->email ?? 'No email' }}
                            </td>
                            <td class="py-2 text-sm">
                                <button type="button"
                                    class="bg-primary-red text-white px-2 py-[3px] text-sm rounded-lg delete-btn-user"
                                    data-id="{{ $employee->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    <!-- Row -->
                </tbody>
            </table>
            <div class="flex justify-between items-center my-5 pl-5">
                {{ $employees->appends(['search' => $search, 'role' => $roleFilter])->links() }}
            </div>
        </div>
    </main>
</x-layouts.layout>
<script>
    document.getElementById('roleFilter').addEventListener('change', function() {
        // Kirim form secara otomatis
        document.getElementById('filterForm').submit();
    });
</script>
