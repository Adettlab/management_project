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
                @if (!auth()->user()->employee || auth()->user()->employee->role->name != 'Project Director')
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

            @auth
                @if (auth()->user()->role === 'admin' || auth()->user()->employee->role->name === 'Project Director')
                    <a href="{{ route('projects.create') }}"
                        class="bg-primary-black flex justify-center items-center hover:bg-zinc-500 cursor-pointer text-white sm:text-xs xs:text-[10px] sm:px-4 xs:px-3 sm:py-1 xs:py-2 rounded-lg hover:bg-gray-800 whitespace-nowrap">
                        <svg class="size-4 text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14m-7 7V5" />
                        </svg>
                        <span class="sm:inline xs:hidden">Create Project</span>
                        <span class="sm:hidden xs:inline">Create</span>
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
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 xs:bg-white sm:bg-none">
                    <!-- Row -->
                    @foreach ($projects as $index => $project)
                        <tr class="group hover:bg-[#F5F5F5] font-medium
                            @if (auth()->user()->role === 'admin' || auth()->user()->employee->role->name === 'Project Director') cursor-pointer @endif"
                            @if (auth()->user()->role === 'admin' || auth()->user()->employee->role->name === 'Project Director') onclick="window.location.href='{{ route('projects.edit', $project->id) }}'" @endif>
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
                                {{ \Carbon\Carbon::parse($project->end_date)->locale('id')->translatedFormat('d F Y') }}
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
                            <!-- Row -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-between items-center my-5 pl-5">
                {{ $projects->links() }}
            </div>
        </div>
    </main>
</x-layouts.layout>
