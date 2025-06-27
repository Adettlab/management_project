<x-layouts.layout :title="$title" :active="$active">
    <main class="max-w-screen w-full mx-auto rounded-xl bg-white border">
        <!-- Search and Add Button -->
        <div class="flex items-center justify-between mb-2 pt-3 pr-6">
            <form action="" method="GET" class="w-1/2 flex space-x-4 pl-4">
                <!-- Filter by Project Level -->
                <div>
                    <select name="project_level"
                        class="primary-gray font-medium rounded-lg py-1 px-2 text-sm border outline-none"
                        onchange="this.form.submit()">
                        <option value="">Filter by Level</option>
                        <option value="low" {{ request('project_level') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('project_level') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('project_level') === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
                
                <!-- Filter by Project Director -->
                @php
                    // PERBAIKAN: Logic untuk menampilkan filter director
                    $showDirectorFilter = false;
                    $user = auth()->user();
                    
                    if ($user->isAdmin()) {
                        $showDirectorFilter = true;
                    } elseif ($user->hasCustomPermissions()) {
                        // Jika user punya custom permission untuk projects dan bisa lihat semua
                        $page = \App\Models\Page::where('name', 'projects')->first();
                        if ($page) {
                            $permission = $user->permissions()->where('page_id', $page->id)->first();
                            $showDirectorFilter = $permission && $permission->allow_view;
                        }
                    } elseif ($user->employee && $user->employee->role->name === 'Project Director') {
                        $showDirectorFilter = true;
                    }
                @endphp

                @if ($showDirectorFilter)
                    <div>
                        <select name="project_director" class="primary-gray font-medium rounded-lg py-1 px-2 text-sm border outline-none" onchange="this.form.submit()">
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
                        class="primary-gray font-medium rounded-lg py-1 px-2 text-sm border outline-none"
                        onchange="this.form.submit()">
                        <option value="">Filter by Status</option>
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
                        class="bg-primary-black flex justify-center items-center hover:bg-zinc-500 cursor-pointer text-white text-xs px-4 py-1 rounded-lg hover:bg-gray-800">
                        <svg class="size-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14m-7 7V5" />
                        </svg>
                        Create Project
                    </a>
                @endif
            @endauth
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse ">
                <thead class="bg-[#F9F9F9]">
                    <tr>
                        <th class="w-[2%] pl-4 py-2 primary-gray text-left font-medium text-sm">#</th>
                        <th class="w-[14%] px-4 py-2 primary-gray text-left font-medium text-sm">Project Name</th>
                        <th class="w-[6%] py-2 primary-gray text-center font-medium text-sm">Start Date</th>
                        <th class="w-[6%] py-2 primary-gray text-center font-medium text-sm">Deadline</th>
                        <th class="w-[6%] py-2 primary-gray text-center font-medium text-sm text-center">Project Director</th>
                        <th class="w-[6%] py-2 primary-gray text-center font-medium text-sm">Project Level</th>
                        <th class="w-[7%] py-2 primary-gray text-center font-medium text-sm w-24">Project Status</th>
                        {{-- PERBAIKAN: Tampilkan kolom action jika ada permission --}}
                        @if ($canUpdate || $canDelete)
                            <th class="w-[8%] py-2 primary-gray text-center font-medium text-sm">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($projects as $index => $project)
                        <tr class="group hover:bg-[#F5F5F5] font-medium
                            @if ($canUpdate) cursor-pointer @endif"
                            @if ($canUpdate)
                                onclick="handleRowClick(event, '{{ route('projects.edit', $project->id) }}')"
                            @endif>
                            <td class="pl-4 py-2 text-sm">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-2 text-sm">
                                {{ $project->name }}
                            </td>
                            <td class="px-4 py-2 text-sm text-center">
                                {{ \Carbon\Carbon::parse($project->start_date)->locale('id')->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-4 py-2 text-sm text-center">
                                {{ \Carbon\Carbon::parse($project->end_date)->locale('id')->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-4 py-2 text-sm text-center">
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
                            <td class="p-3">
                                <div class="flex items-center justify-center">
                                    <p class="text-white text-sm px-3 rounded-full"
                                        style="background-color: {{ $project->level->color }}">
                                        {{ $project->level->name }}
                                    </p>
                                </div>
                            </td>
                            <td class="p-3">
                                <div class="flex items-center justify-center">
                                    <p class="text-white text-sm px-3 rounded-full"
                                        style="background-color: {{ $project->status->color }}">
                                        {{ $project->status->name }}
                                    </p>
                                </div>
                            </td>

                            {{-- PERBAIKAN: Action buttons berdasarkan permission --}}
                            @if ($canUpdate || $canDelete)
                                <td class="px-4 py-2 text-sm text-center">
                                    <div class="flex justify-center space-x-2">
                                        @if ($canUpdate)
                                            <a href="{{ route('projects.edit', $project->id) }}" 
                                               class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs"
                                               onclick="event.stopPropagation()">
                                                Edit
                                            </a>
                                        @endif
                                        
                                        @if ($canDelete)
                                            <button type="button"
                                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs delete-btn-project"
                                                data-id="{{ $project->id }}"
                                                onclick="event.stopPropagation()">
                                                Delete
                                            </button>
                                        @endif

                                        {{-- View button untuk user yang tidak bisa edit --}}
                                        @if (!$canUpdate)
                                            <a href="{{ route('projects.show', $project->id) }}" 
                                               class="bg-gray-500 hover:bg-gray-600 text-white px-2 py-1 rounded text-xs"
                                               onclick="event.stopPropagation()">
                                                View
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-between items-center my-5 pl-5">
                {{ $projects->links() }}
            </div>
        </div>
    </main>

    {{-- PERBAIKAN: JavaScript untuk handle row click dan delete --}}
    <script>
        // Handle row click, tapi tidak trigger jika click pada button
        function handleRowClick(event, url) {
            // Jangan redirect jika yang diklik adalah button/link di dalam row
            if (event.target.tagName === 'BUTTON' || event.target.tagName === 'A' || event.target.closest('button') || event.target.closest('a')) {
                return;
            }
            window.location.href = url;
        }

        // Handle delete project
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn-project');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const projectId = this.getAttribute('data-id');
                    
                    if (confirm('Are you sure you want to delete this project?')) {
                        fetch(`/projects/${projectId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert(data.message || 'Error deleting project');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error deleting project');
                        });
                    }
                });
            });
        });
    </script>
</x-layouts.layout>