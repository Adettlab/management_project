<x-layouts.layout :title="$title" :active="$active">
    <main class="flex-1 p-6 bg-white shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Edit Task</h1>
        <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Task Name, Project -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="name">Task Name</label>
                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full text-sm py-1 px-2 border border-gray-300 rounded-md"
                        value="{{ old('name', $task->name) }}" required>
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="project_id">Project</label>
                    <select name="project_id"
                        class="mt-1 py-1 px-2 block w-full text-sm border border-gray-300 rounded-md" id="project_id"
                        required>
                        <option value="">Select project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}"
                                {{ $task->project_id == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}</option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Task Level, Status -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="task_level_id">Task Level</label>
                    <select name="task_level_id"
                        class="mt-1 py-1 px-2 block w-full text-sm border border-gray-300 rounded-md" id="task_level_id"
                        required>
                        <option value="">Select task level</option>
                        @foreach ($taskLevels as $level)
                            <option value="{{ $level->id }}"
                                {{ $task->task_level_id == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('task_level_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="task_status_id">Task Status</label>
                    <select name="task_status_id"
                        class="mt-1 py-1 px-2 block w-full text-sm border border-gray-300 rounded-md"
                        id="task_status_id" required>
                        <option value="">Select task status</option>
                        @foreach ($taskStatuses as $status)
                            <option value="{{ $status->id }}"
                                {{ $task->task_status_id == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}</option>
                        @endforeach
                    </select>
                    @error('task_status_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Assigned Project Employee -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="assigned_project_employee_id">Assign
                    To</label>
                <select name="assigned_project_employee_id"
                    class="mt-1 py-1 px-2 block w-full text-sm border border-gray-300 rounded-md"
                    id="assigned_project_employee_id">
                    <option value="">Select employee</option>
                    @foreach ($projectEmployees as $projectEmployee)
                        <option value="{{ $projectEmployee->id }}"
                            {{ $task->assigned_project_employee_id == $projectEmployee->id ? 'selected' : '' }}>
                            {{ $projectEmployee->employee?->user?->name ?? 'Unknown Employee' }}
                            ({{ $projectEmployee->project?->name ?? 'Unknown Project' }})
                        </option>
                    @endforeach
                </select>
                @error('assigned_project_employee_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Task Description -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="description">Task Description</label>
                <textarea name="description" id="description" rows="6"
                    class="mt-1 py-1 px-2 block w-full text-sm border border-gray-300 rounded-md">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ url()->previous() }}"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
            </div>
        </form>
    </main>
</x-layouts.layout>
