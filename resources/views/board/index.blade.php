<x-layouts.layout :title="$title" :active="$active">
    <main class="flex flex-col">
        <div class="mb-4">
            <h1 class="text-2xl font-semibold">Board</h1>
            <p>In this section you can choose one of your projects to show it's Kanban board</p>
        </div>
        <div class="flex justify-center w-full h-full">
            <div class="bg-white shadow-md rounded-lg p-4 w-[55%] h-[30%]">
                <div class="flex flex-col justify-start gap-y-2">
                    <label for="project_id">Project</label>
                    <select name="project_id" class="mt-1 py-2 px-2 block text-sm border border-gray-300 rounded-md"
                        id="project_id" required>
                        <option value="">Select project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                    <div class="flex items-center justify-between mt-4">
                        <div>
                            <p class="mb-2">Choose a project to show it's board</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-center items-center h-full mt-5">
            <div class="bg-white shadow-md rounded-lg p-1 flex justify-center items-center w-[55%] h-[60%]">
                <img src="{{ asset('board.png') }}" alt="Kanban Board" class="w-full">
            </div>
        </div>
    </main>

</x-layouts.layout>

<script>
    document.getElementById('project_id').addEventListener('change', function() {
        const projectId = this.value; // Ambil ID proyek yang dipilih

        // Redirect ke halaman project.show jika ada ID yang dipilih
        if (projectId) {
            window.location.href = "{{ url('/board') }}/" + projectId;
        }
    });
</script>
