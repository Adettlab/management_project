<x-layouts.layout :title="$title" :active="$active">
    <main class="max-w-screen w-full mx-auto rounded-xl sm:bg-white xs:bg-none sm:border">
        <!-- Search and Add Button -->
        <div class="flex items-center justify-between mb-2 pt-3 sm:pr-6 xs:pr-[10px] xs:px-2 sm:px-0">
            <form action="" method="GET" class="w-1/2 flex sm:space-x-4 xs:space-x-1 sm:pl-4 xs:pl-0.5">
                <!-- Filter by Project Level -->
                <div>
                    <select name="project_level"
                        class="primary-gray font-medium rounded-lg sm:py-1 xs:py-2 sm:px-2 sm:text-sm xs:text-[10px] border outline-none"
                        onchange="this.form.submit()">
                        <option value="">Filter by Level</option>
                        <option value="low" {{ request('project_level') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('project_level') === 'medium' ? 'selected' : '' }}>Medium
                        </option>
                        <option value="high" {{ request('project_level') === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                <!-- Filter by Project Director -->
                @php
                    // PERBAIKAN: Logic untuk menampilkan filter director menggunakan model baru
                    $showDirectorFilter = false;
                    $user = auth()->user();

                    if ($user->isAdmin()) {
                        $showDirectorFilter = true;
                    } elseif ($user->hasCustomPermissions()) {
                        // Menggunakan model SiMenuWeb yang baru
                        $menu = \App\Models\SiMenuWeb::where('teks', 'projects')->first();
                        if ($menu) {
                            $permission = $user->permissions()->where('menu_id', $menu->id)->first();
                            $showDirectorFilter = $permission && $permission->allow_view;
                        }
                    } elseif ($user->employee && $user->employee->role->name === 'Project Director') {
                        $showDirectorFilter = true;
                    }
                @endphp

                @if ($showDirectorFilter)
                    <div>
                        <select name="project_director"
                            class="primary-gray font-medium rounded-lg sm:py-1 xs:py-2 sm:px-2 sm:text-sm xs:text-[10px] border outline-none"
                            onchange="this.form.submit()">
                            <option value="">Filter by Director</option>
                            @foreach ($directors as $director)
                                <option value="{{ $director->id }}"
                                    {{ request('project_director') == $director->id ? 'selected' : '' }}>
                                    {{ $director->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Filter by Project Status -->
                <div>
                    <select name="project_status"
                        class="primary-gray font-medium rounded-lg sm:py-1 xs:py-2 sm:px-2 sm:text-sm xs:text-[10px] border outline-none"
                        onchange="this.form.submit()">
                        <option value="">
                            Filter by Status
                        </option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}"
                                {{ request('project_status') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            {{-- PERBAIKAN: Create button berdasarkan permission --}}
            @auth
                @if ($canCreate)
                    <a href="{{ route('projects.create') }}"
                        class="bg-primary-black flex justify-center items-center hover:bg-zinc-500 cursor-pointer text-white sm:text-xs xs:text-[10px] sm:px-4 xs:px-3 sm:py-1 xs:py-2 rounded-lg hover:bg-gray-800 whitespace-nowrap">
                        <svg class="size-4 text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14m-7 7V5" />
                        </svg>
                        <span class="sm:inline xs:hidden">Buat Project</span>
                        <span class="sm:hidden xs:inline">Buat</span>
                    </a>
                @endif
            @endauth
        </div>

        <!-- Table -->
        <div
            class="overflow-x-auto xs:mx-3 sm:mx-0 xs:shadow-[0_0_0_0.8px_rgba(0,0,0,0.19)] sm:shadow-none xs:rounded-xl">
            <table class="w-full border-collapse">
                <thead class="bg-[#F9F9F9]">
                    <tr>
                        <th
                            class="w-[2%] pl-4 sm:py-2 xs:py-5 primary-gray text-left font-medium sm:text-sm xs:text-[12px]">
                            #</th>
                        <th
                            class="w-[14%] px-4 sm:py-2 xs:py-5 primary-gray text-left font-medium sm:text-sm xs:text-[12px]">
                            Project <span class="hidden sm:inline">Name</span>
                        </th>
                        <th class="w-[6%] py-2 primary-gray text-center font-medium text-sm hidden sm:table-cell">Start
                            Date</th>
                        <th class="w-[6%] py-2 primary-gray text-center font-medium text-sm hidden sm:table-cell">
                            Deadline</th>
                        <th
                            class="sm:w-[6%] xs:w-[10%] sm:py-2 xs:py-5 primary-gray text-center font-medium sm:text-sm xs:text-[12px] text-center">
                            Project
                            Director
                        </th>
                        <th class="w-[6%] py-2 primary-gray text-center font-medium hidden sm:table-cell">Project Level
                        </th>
                        <th
                            class="w-[7%] sm:py-2 xs:py-5 primary-gray text-center font-medium sm:text-sm xs:text-[12px] w-24">
                            <span class="hidden sm:inline">Project</span> Status
                        </th>
                        {{-- PERBAIKAN: Tampilkan kolom action jika ada permission --}}
                        @if ($canUpdate || $canDelete)
                            <th
                                class="w-[7%] sm:py-2 xs:py-5 primary-gray text-center font-medium text-sm sm:text-sm xs:text-[12px]">
                                Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 xs:bg-white sm:bg-none">
                    <!-- Row -->
                    @forelse ($projects as $index => $project)
                        <tr class="group hover:bg-[#F5F5F5] font-medium
                            @if ($canUpdate) cursor-pointer @endif"
                            @if ($canUpdate) onclick="handleRowClick(event, '{{ route('projects.edit', $project->id) }}')" @endif>
                            <td class="pl-4 py-2 sm:text-sm xs:text-[12px]">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-2 sm:text-sm xs:text-[12px]">
                                {{ $project->name }}
                            </td>
                            <td class="px-4 py-2 text-sm text-center hidden sm:table-cell">
                                {{ \Carbon\Carbon::parse($project->start_date)->locale('id')->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-4 py-2 text-sm text-center hidden sm:table-cell">
                                {{-- {{ \Carbon\Carbon::parse($project->end_date)->locale('id')->translatedFormat('d F Y') }} --}}
                                @php
                                    $endDate = \Carbon\Carbon::parse($project->end_date);
                                    $today = \Carbon\Carbon::now();
                                    $isOverdue = $endDate->isPast() && $project->status->name !== 'Finish';
                                @endphp
                                <span class="{{ $isOverdue ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $endDate->locale('id')->translatedFormat('d M Y') }}
                                </span>
                                @if ($isOverdue)
                                    <div class="text-xs text-red-500">Terlambat</div>
                                @endif
                            </td>
                            <td class="px-4 py-2 sm:text-sm xs:text-[12px] text-center">
                                @php
                                    $directors = $project->employees->where('role.name', 'Project Director');
                                @endphp
                                @if ($directors->isNotEmpty())
                                    {{ $directors->map(function ($employee) {
                                            return $employee->user->name;
                                        })->implode(', ') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="p-3 hidden sm:table-cell">
                                <div class="flex items-center justify-center">
                                    <p class="text-white text-sm px-3 rounded-full"
                                        style="background-color: {{ $project->level->color }}">
                                        {{ $project->level->name }}
                                    </p>
                                </div>
                            </td>
                            <td class="p-3">
                                <div class="flex items-center justify-center">
                                    <p class="text-white sm:text-sm xs:text-[12px] px-3 rounded-full"
                                        style="background-color: {{ $project->status->color }}">
                                        {{ $project->status->name }}
                                    </p>
                                </div>
                            </td>

                            {{-- PERBAIKAN: Action buttons berdasarkan permission --}}
                            @if ($canUpdate || $canDelete)
                                <td class="px-4 py-2 text-sm text-center">
                                    <div class="flex justify-center space-x-1">
                                        @if ($canUpdate)
                                            <a href="{{ route('projects.edit', $project->id) }}"
                                                class="bg-blue-500 sm:text-sm xs:text-[12px] hover:bg-blue-600 text-white px-2 rounded transition-colors"
                                                onclick="event.stopPropagation()" title="Edit Project">
                                                Edit
                                            </a>
                                        @endif

                                        <a href="{{ route('projects.show', $project->id) }}"
                                            class="bg-gray-500 hover:bg-gray-600 text-white px-2 rounded sm:text-sm xs:text-[12px] transition-colors"
                                            onclick="event.stopPropagation()" title="Lihat Detail">
                                            Detail
                                        </a>

                                        @if ($canDelete)
                                            <button type="button"
                                                class="bg-red-500 hover:bg-red-600 text-white px-2 rounded sm:text-sm xs:text-[12px] delete-btn-project transition-colors"
                                                data-id="{{ $project->id }}" data-name="{{ $project->name }}"
                                                onclick="event.stopPropagation()" title="Hapus Project">
                                                Hapus
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            @else
                                {{-- Jika user hanya bisa view --}}
                                <td class="px-4 py-2 text-sm text-center">
                                    <a href="{{ route('projects.show', $project->id) }}"
                                        class="bg-gray-500 hover:bg-gray-600 text-white px-3 rounded sm:text-sm xs:text-[12px] transition-colors"
                                        onclick="event.stopPropagation()">
                                        Lihat
                                    </a>
                                </td>
                            @endif
                        </tr>
                        <!-- Row -->
                    @empty
                        <tr>
                            <td colspan="{{ $canUpdate || $canDelete ? '8' : '7' }}"
                                class="px-4 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada project</p>
                                    <p class="text-sm">
                                        @if ($canCreate)
                                            <a href="{{ route('projects.create') }}"
                                                class="text-blue-600 hover:text-blue-800">Buat project pertama</a>
                                        @else
                                            Anda belum memiliki akses ke project manapun
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($projects->hasPages())
                <div class="flex justify-between items-center my-5 pl-5">
                    {{ $projects->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </main>

    {{-- PERBAIKAN: JavaScript untuk handle row click dan delete --}}
    <script>
        // Handle row click, tapi tidak trigger jika click pada button
        function handleRowClick(event, url) {
            // Jangan redirect jika yang diklik adalah button/link di dalam row
            if (event.target.tagName === 'BUTTON' || event.target.tagName === 'A' || event.target.closest('button') || event
                .target.closest('a')) {
                return;
            }
            window.location.href = url;
        }

        // Add CSRF token to meta if not exists
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = '{{ csrf_token() }}';
            document.getElementsByTagName('head')[0].appendChild(meta);
        }
    </script>
</x-layouts.layout>
