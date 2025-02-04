<x-layouts.layout :title="$title" :active="$active">
    <main class="p-4">
        <div class="text-3xl font-semibold mb-4">Kanban Board</div>
        <div class="bg-white shadow-md rounded-lg p-3">
            <div class="container mx-auto">
                <div class="flex space-x-4" id="kanban-board">
                    <!-- Pending Column -->
                    <div class="w-1/3">
                        <div class="bg-white shadow-lg rounded-lg">
                            <div class="bg-blue-500 text-white p-4 rounded-t-lg">
                                <div class="text-lg">Pending</div>
                            </div>
                            <div class="p-4 connectedSortable" id="todo" ondrop="drop(event)"
                                ondragover="allowDrop(event)">
                                <!-- Kanban Items for Pending -->
                                @foreach ($tasks as $task)
                                    @if ($task->taskStatus->name === 'Pending')
                                        <div class="bg-gray-100 p-2 my-2 rounded shadow" id="task-{{ $task->id }}"
                                            draggable="true" ondragstart="drag(event)"
                                            data-task-id="{{ $task->id }}">
                                            <h4 class="font-semibold">{{ $task->name }}</h4>
                                            <p>{{ $task->description }}</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- In Progress Column -->
                    <div class="w-1/3">
                        <div class="bg-white shadow-lg rounded-lg">
                            <div class="bg-yellow-500 text-white p-4 rounded-t-lg">
                                <div class="text-lg">In Progress</div>
                            </div>
                            <div class="p-4 connectedSortable" id="in_progress" ondrop="drop(event)"
                                ondragover="allowDrop(event)">
                                <!-- Kanban Items for In Progress -->
                                @foreach ($tasks as $task)
                                    @if ($task->taskStatus->name === 'In Progress')
                                        <div class="bg-gray-100 p-2 my-2 rounded shadow" id="task-{{ $task->id }}"
                                            draggable="true" ondragstart="drag(event)"
                                            data-task-id="{{ $task->id }}">
                                            <h4 class="font-semibold">{{ $task->name }}</h4>
                                            <p>{{ $task->description }}</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Completed Column -->
                    <div class="w-1/3">
                        <div class="bg-white shadow-lg rounded-lg">
                            <div class="bg-green-500 text-white p-4 rounded-t-lg">
                                <div class="text-lg">Completed</div>
                            </div>
                            <div class="p-4 connectedSortable" id="completed" ondrop="drop(event)"
                                ondragover="allowDrop(event)">
                                <!-- Kanban Items for Completed -->
                                @foreach ($tasks as $task)
                                    @if ($task->taskStatus->name === 'Completed')
                                        <div class="bg-gray-100 p-2 my-2 rounded shadow" id="task-{{ $task->id }}"
                                            draggable="true" ondragstart="drag(event)"
                                            data-task-id="{{ $task->id }}">
                                            <h4 class="font-semibold">{{ $task->name }}</h4>
                                            <p>{{ $task->description }}</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.layout>

<script>
    function allowDrop(event) {
        event.preventDefault();
    }

    function drag(event) {
        event.dataTransfer.setData("text", event.target.id);
    }

    function drop(event) {
        event.preventDefault();

        // Pastikan bahwa kita men-drop hanya pada kolom kanban yang valid
        const targetColumn = event.currentTarget;
        const taskId = event.dataTransfer.getData("text");
        const taskElement = document.getElementById(taskId);

        // Pindahkan elemen task ke dalam kolom target yang benar
        targetColumn.appendChild(taskElement);

        // Map target ID ke task_status_id
        const statusMap = {
            'todo': 1, // Pending
            'in_progress': 2, // In Progress
            'completed': 3 // Completed
        };
        const taskStatusId = statusMap[targetColumn.id];

        // Panggil fungsi untuk memperbarui status task di server
        updateTaskStatus(taskElement.getAttribute("data-task-id"), taskStatusId);
    }

    function updateTaskStatus(taskId, taskStatusId) {
        fetch(`/tasks/${taskId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan CSRF token
                },
                body: JSON.stringify({
                    task_status_id: taskStatusId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(`Task ${taskId} status updated successfully.`);
                } else {
                    console.error('Failed to update task status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>
