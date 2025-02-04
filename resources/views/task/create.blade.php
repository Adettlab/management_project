<x-layouts.layout :title="$title" :active="$active">
    <main class="flex-1 p-6 bg-white shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Create Task</h1>
        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Task Name, Project -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <!-- Task Name Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="name">Task Name</label>
                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                        placeholder="Task name..." required>
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Project Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="project_id">Project</label>
                    <select name="project_id"
                        class="mt-1 py-1 px-2 block w-full text-sm border border-gray-300 rounded-md" id="project_id"
                        required>
                        <option value="">Select project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Task Level, Status -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <!-- Task Level -->
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="task_level_id">Task Level</label>
                    <select name="task_level_id"
                        class="mt-1 py-1 px-2 block w-full text-sm border border-gray-300 rounded-md" id="task_level_id"
                        required>
                        <option value="">Select task level</option>
                        @foreach ($taskLevels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('task_level_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Task Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="task_status_id">Task Status</label>
                    <select name="task_status_id"
                        class="mt-1 py-1 px-2 block w-full text-sm border border-gray-300 rounded-md"
                        id="task_status_id" required>
                        <option value="">Select task status</option>
                        @foreach ($taskStatuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                    @error('task_status_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Assign to Project Employee -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="assigned_project_employee_id">Assign to
                    Employee</label>

                {{-- @dd($projectEmployee->employee->role->name); --}}
                @if ($isEmployee && $projectEmployee->employee->role->name != 'Project Director')
                    <!-- Input otomatis jika user adalah employee -->
                    {{-- @dd($projectEmployee); --}}
                    <input type="hidden" name="assigned_project_employee_id" value="{{ $projectEmployee->id }}">
                    <input type="text" value="{{ $projectEmployee->employee->user->name }}"
                        class="mt-1 py-1 px-2 block w-full text-sm border border-gray-300 rounded-md bg-gray-100"
                        readonly>
                @else
                    <!-- Dropdown untuk admin -->
                    <select name="assigned_project_employee_id"
                        class="mt-1 py-1 px-2 block w-full text-sm border border-gray-300 rounded-md"
                        id="assigned_project_employee_id" required>
                        <option value="">Select employee</option>
                        @foreach ($projectEmployees as $employee)
                            <option value="{{ $employee->id }}">
                                {{ $employee->employee?->user?->name ?? 'No Name' }}
                                ({{ $employee->project?->name ?? 'No Project' }})
                            </option>
                        @endforeach
                    </select>

                @endif
                @error('assigned_project_employee_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>



            <!-- Task Description -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="description">Task Description</label>
                <textarea name="description" id="description" rows="6" placeholder="Task description..."
                    class="mt-1 py-1 px-2 block w-full text-sm border border-gray-300 rounded-md"></textarea>
                @error('description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ url()->previous() }}"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Create</button>
            </div>
        </form>
    </main>
</x-layouts.layout>
