<x-layouts.layout :title="$title" :active="$active">
    <main class="p-2">
        <div class="flex items-center justify-between w-full pb-2 mb-3">
            <div class="flex w-[40%] gap-x-3">
                <div class="w-fit relative z-20">
                    <button id="dropdown-button-projects" class="inline-flex items-center w-full px-2 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm z-20" onclick="taskManager.toggleDropdown('projects-dropdown', 'projects-icon', event)">
                        <span class="mr-auto" id="project-value">Projects</span>
                        <svg id="projects-icon" xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 ml-2 transform transition-transform duration-500" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <ul id="projects-dropdown"
                        class="w-fit absolute right-0 left-0 mt-2 rounded-md shadow-lg bg-white p-1 space-y-1 transform opacity-0 scale-95 -translate-y-2 hidden transition-all duration-300 ease-out origin-top">
                    </ul>
                </div>
                <div class="w-fit">
                    <input type="date" name="date-filter" id="date-filter"
                        class="w-full px-2 py-[1.5px] rounded-md border" onchange="taskManager.fetchTasks(this.value)"
                        value="{{ date('Y-m-d') }}">
                </div>
            </div>
            @if ($errors->has('error'))
                <div class="flex justify-center items-center mx-4">
                    <div class="flex flex-row justify-center items-center bg-red-100 rounded-lg p-2 text-xs text-red-700 w-fit whitespace-nowrap" role="alert">
                        <svg class="w-4 h-4 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            Something went wrong. Please try again or contact support
                        </div>
                    </div>
                </div>
            @endif
            <div class="w-[30%] flex justify-end space-x-4">
                <div class="w-1/3">
                    <button id="openModalCreateBtn"
                        class="bg-primary-black flex items-center justify-center w-full text-xs text-white px-4 py-2 rounded-md hover:bg-zinc-700 whitespace-nowrap">
                        <svg class="size-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14m-7 7V5" />
                        </svg>
                        Create task
                    </button>
                </div>

                    @if (auth()->user()->role === 'admin' || auth()->user()->employee->role->name === 'Project Director')
                        <div class="w-1/3">
                            <button id="openModalTransferBtn"
                                class="bg-primary-black flex items-center justify-center w-full text-xs text-white px-4 py-2 rounded-md hover:bg-zinc-700 whitespace-nowrap">
                                <svg class="size-3 text-white mr-1" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.4117 2.44334C17.8288 1.28955 16.7108 0.171484 15.557 0.589552L1.45567 5.68939C0.298018 6.10843 0.158019 7.68801 1.22298 8.30497L5.7242 10.9109L9.74364 6.89146C9.92573 6.71558 10.1696 6.61826 10.4228 6.62046C10.6759 6.62266 10.9181 6.72421 11.0971 6.90322C11.2761 7.08223 11.3777 7.3244 11.3799 7.57755C11.3821 7.83071 11.2847 8.0746 11.1089 8.25669L7.08944 12.2761L9.69633 16.7773C10.3123 17.8423 11.8919 17.7013 12.3109 16.5447L17.4117 2.44334Z"
                                        fill="white" />
                                </svg>
                                Transfer task
                            </button>
                        </div>

                        <div class="w-1/3">
                            <a href="{{ route('tasks.allTask') }}"
                                class="bg-primary-black flex items-center justify-center w-full text-xs text-white px-4 py-2 rounded-md hover:bg-zinc-700 whitespace-nowrap">
                                See All Task
                            </a>
                        </div>
                    @endif

            </div>
        </div>
        <div class="container mx-auto max-w-full">
            <div class="flex space-x-4 w-full" id="kanban-board">
                <!-- To Do Column -->
                <div class="w-1/4 h-fit pb-4">
                    <div class="bg-white rounded-lg">
                        <div class="bg-primary-red text-white pt-2 rounded-t-lg">
                            <div class="text-md primary-black font-semibold bg-white px-3 pt-1">To do</div>
                        </div>
                        <div id="todo" class="p-4 connectedSortable">
                        </div>
                    </div>
                </div>

                <!-- In Progress Column -->
                <div class="w-1/4 h-fit pb-8">
                    <div class="bg-white rounded-lg">
                        <div class="bg-primary-orange text-white pt-2 rounded-t-lg">
                            <div class="text-md primary-black font-semibold bg-white px-3 pt-1">In progres</div>
                        </div>
                        <div id="in_progress" class="p-4 connectedSortable" ondrop="taskManager.drop(event)"
                            ondragover="taskManager.allowDrop(event)">
                        </div>
                    </div>
                </div>

                <!-- Review Column -->
                <div class="w-1/4 h-fit">
                    <div class="bg-white rounded-lg">
                        <div class="bg-sky-blue text-white pt-2 rounded-t-lg">
                            <div class="text-md primary-black font-semibold bg-white px-3 pt-1">Riview</div>
                        </div>
                        <div id="review" class="p-4 connectedSortable" ondrop="taskManager.drop(event)"
                            ondragover="taskManager.allowDrop(event)">
                        </div>
                    </div>
                </div>

                <!-- Completed Column -->
                <div class="w-1/4 h-fit">
                    <div class="bg-white  rounded-lg">
                        <div class="bg-primary-green text-white pt-2 rounded-t-lg">
                            <div class="text-md primary-black font-semibold bg-white px-3 pt-1">Completed</div>
                        </div>
                        <div id="completed" class="p-4 connectedSortable" ondrop="taskManager.drop(event)"
                            ondragover="taskManager.allowDrop(event)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="loading" class="hidden">
            <div class="flex items-center justify-center w-full h-full">
                <div class="flex justify-center items-center space-x-1 text-sm text-gray-700">

                    <svg fill='none' class="w-6 h-6 animate-spin" viewBox="0 0 32 32"
                        xmlns='http://www.w3.org/2000/svg'>
                        <path clip-rule='evenodd'
                            d='M15.165 8.53a.5.5 0 01-.404.58A7 7 0 1023 16a.5.5 0 011 0 8 8 0 11-9.416-7.874.5.5 0 01.58.404z'
                            fill='currentColor' fill-rule='evenodd' />
                    </svg>


                    <div>Loading ...</div>
                </div>
            </div>
        </div>
        <div id="no_tasks" class="hidden">
            <div class="flex items-center justify-center w-full h-full">
                <div class="flex justify-center items-center space-x-1 text-sm text-gray-700">
                    <div class="text-xl">Tidak ada tasks untuk tanggal ini</div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.layout>

<!-- Modal Create -->
<div id="modalCreate" class="fixed inset-0 z-[999] flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md h-[340px]">
        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b px-4">
            <h2 class="text-md font-semibold">Create Task</h2>
            <button id="closeModalCreateBtn" class="text-gray-500 hover:text-gray-700 text-[32px]">&times;</button>
        </div>
        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Modal Body -->
            <div class="py-4 px-8 space-y-3">
                <!-- Task Name -->
                <div class="space-y-1">
                    <label class="block text-sm text-gray-700">Task</label>
                    <input type="text" placeholder="Task name..." name="name"
                        class="w-full bg-primary-white border border-primary-white px-3 py-1 text-sm rounded focus:outline-none">
                </div>

                <!-- Project -->
                <div class="space-y-1 relative">
                    <label class="block text-sm text-gray-700">Project</label>
                    <button id="dropdown-create-task"
                        class="inline-flex items-center w-full px-3 py-1 text-sm bg-primary-white border border-primary-white rounded-md shadow-sm"
                        onclick="taskManager.toggleDropdown('create-task-dropdown', 'create-task-icon', event)">
                        <span class="mr-auto" id="create-project-value">Select Projects</span>
                        <svg id="create-task-icon" class="w-5 h-5 ml-2 transform transition-transform duration-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <ul id="create-task-dropdown"
                        class="w-full absolute right-0 mt-2 rounded-md shadow-lg bg-primary-white border border-primary-white p-1 space-y-1 transform opacity-0 scale-95 -translate-y-2 hidden transition-all duration-300 ease-out origin-top">
                        @foreach ($projects as $project)
                            <li class="block px-4 py-2 text-black hover:bg-[#C3C3C3] cursor-pointer rounded-md"
                                data-project-value="{{ $project->id }}"
                                onclick="taskManager.listOnClick(event, 'create-project-value', 'create-task-dropdown', 'create-task-icon', 'project_id_create', {{ $project->id }})">
                                {{ $project->name }}</li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="project_id" id="project_id_create">
                </div>

                <!-- Task Level -->
                <div>
                    <div class="flex items-center">
                        <label class="block text-sm text-gray-700 mr-3">Task Level</label>
                        <div class="flex space-x-4 items-center">
                            <label class="flex items-center text-sm">
                                <input type="radio" name="task_level_id" class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="1" /> Low
                            </label>
                            <label class="flex items-center text-sm">
                                <input type="radio" name="task_level_id" class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="2" /> Medium
                            </label>
                            <label class="flex items-center text-sm">
                                <input type="radio" name="task_level_id" class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="3" /> High
                            </label>
                        </div>
                    </div>
                    <p class="text-xs bg-primary-white py-1 px-3 text-slate-600 rounded space-x-6 mt-3">
                        <span class="task-level">Low</span> : &lt; 2 hours
                        <span class="task-level">Medium</span> : &gt; 6 hours
                        <span class="task-level">High</span> : &gt; 6 hours
                    </p>
                </div>
            </div>
            <div>
                <input type="hidden" name="assigned_project_employee_id" id="employee_create">
                <input type="hidden" value="1" name="task_status_id">
                {{-- <input type="hidden" name="task_level_id" id="task_level_id"> --}}
            </div>

            <!-- Modal Footer -->
            <div class="flex w-full px-8 pt-3">
                <button id="submitBtn" type="submit"
                    class="bg-primary-black w-full text-sm text-white px-4 py-2 rounded hover:bg-zinc-700">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>


<div id="modalTransfer"
    class="fixed inset-0 z-[999] flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md h-fit pb-10">
        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b px-4">
            <h2 class="text-md font-semibold">Transfer Task</h2>
            <button id="closeModalTransferBtn" class="text-gray-500 hover:text-gray-700 text-[32px]">&times;</button>
        </div>
        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Modal Body -->
            <div class="py-4 px-8 space-y-3">
                <!-- Task Name -->
                <div class="space-y-1">
                    <label class="block text-sm text-gray-700" for="name">Task</label>
                    <input type="text" placeholder="Task name..." name="name" id="name"
                        class="w-full bg-primary-white border border-primary-white px-3 py-1 text-sm rounded focus:outline-none">

                </div>

                <!-- Project -->
                <div class="space-y-1 relative">
                    <label class="block text-sm text-gray-700" for="project_id">Project</label>
                    <button id="dropdown-transfer-task"
                        class="inline-flex items-center w-full px-3 py-1 text-sm bg-primary-white border border-primary-white rounded-md shadow-sm"
                        onclick="taskManager.toggleDropdown('trasfer-task-dropdown', 'trasfer-task-icon', event)">
                        <span class="mr-auto" id="trasfer-task-value">Select Projects</span>
                        <svg id="trasfer-task-icon" class="w-5 h-5 ml-2 transform transition-transform duration-500"
                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <ul id="trasfer-task-dropdown"
                        class="w-full absolute right-0 mt-2 rounded-md shadow-lg bg-primary-white border p-1 space-y-1 transform opacity-0 scale-95 -translate-y-2 hidden transition-all duration-300 ease-out origin-top z-50">
                        @foreach ($projects as $project)
                            <li class="block px-4 py-2 text-black hover:bg-[#C3C3C3] cursor-pointer rounded-md"
                                onclick="taskManager.listOnClick(event, 'trasfer-task-value', 'trasfer-task-dropdown', 'trasfer-task-icon', 'project_id_transfer', {{ $project->id }})">
                                {{ $project->name }}
                            </li>
                        @endforeach
                    </ul>
                    @error('project_id_transfer')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                    <input type="hidden" name="project_id" id="project_id_transfer">
                </div>

                <!-- Send to -->
                @if (auth()->user()->role === 'admin' || auth()->user()->employee->role->name === 'Project Director')
                    <div class="space-y-1 relative">
                        <label class="block text-sm text-gray-700" for="assigned_project_employee_id">Send to</label>
                        <button id="dropdown-transfer-employee"
                            class="inline-flex items-center w-full px-3 py-1 text-sm bg-primary-white border rounded-md shadow-sm"
                            onclick="taskManager.toggleDropdown('trasfer-employee-dropdown', 'trasfer-employee-icon', event)"
                            disabled>
                            <span class="mr-auto" id="trasfer-employee-value">Select employee</span>
                            <svg id="trasfer-employee-icon"
                                class="w-5 h-5 ml-2 transform transition-transform duration-500" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <ul id="trasfer-employee-dropdown"
                            class="w-full absolute right-0 border mt-2 rounded-md shadow-lg bg-primary-white p-1 space-y-1 transform opacity-0 scale-95 -translate-y-2 hidden transition-all duration-300 ease-out origin-top z-50">
                        </ul>
                        @error('assigned_project_employee_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                        <input type="hidden" name="assigned_project_employee_id" id="assigned_project_employee_id">
                    </div>
                @endif

                <!-- Task Level -->
                <div>
                    <div class="flex items-center">
                        <label class="block text-sm text-gray-700 mr-3">Task Level</label>
                        <div class="flex space-x-4 items-center">
                            <label class="flex items-center text-sm">
                                <input type="radio" name="task_level_id" class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="1" /> Low
                            </label>
                            <label class="flex items-center text-sm">
                                <input type="radio" name="task_level_id" class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="2" /> Medium
                            </label>
                            <label class="flex items-center text-sm">
                                <input type="radio" name="task_level_id" class="mr-2 accent-yellow-500 w-3 h-3 rounded-full checked:bg-yellow-500 checked:border-0 checked:appearance-none" value="3" /> High
                            </label>
                        </div>
                    </div>
                    <p class="text-xs bg-primary-white py-1 px-3 rounded text-slate-600 mt-2 space-x-6">
                        <span class="task-level">Low</span> : &lt; 2 hours
                        <span class="task-level">Medium</span> : &lt; 6 hours
                        <span class="task-level">High</span> : &gt; 6 hours
                    </p>
                </div>
            </div>

            {{-- Task status default --}}
            <div>
                <input type="hidden" value="1" name="task_status_id">
            </div>

            <!-- Modal Footer -->
            <div class="flex w-full px-8">
                <button id="submitBtn" type="submit"
                    class="bg-primary-black w-full text-sm text-white px-4 py-2 rounded hover:bg-zinc-700">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

{{-- modal edit task --}}
<div id="modalShow"
    class="fixed inset-0 z-[999] flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl h-fit pb-10">
        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b px-4">
            <h2 class="text-md font-semibold">Task</h2>
            <div class="flex mr-1 space-x-2">
                <button class="text-white hover:stroke-slate-400 text-[32px]" id="editTaskBtn">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2.5H3C2.46957 2.5 1.96086 2.71071 1.58579 3.08579C1.21071 3.46086 1 3.96957 1 4.5V18.5C1 19.0304 1.21071 19.5391 1.58579 19.9142C1.96086 20.2893 2.46957 20.5 3 20.5H17C17.5304 20.5 18.0391 20.2893 18.4142 19.9142C18.7893 19.5391 19 19.0304 19 18.5V11.5" stroke="#7D7D7D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16.3751 2.12523C16.7729 1.7274 17.3125 1.50391 17.8751 1.50391C18.4377 1.50391 18.9773 1.7274 19.3751 2.12523C19.7729 2.52305 19.9964 3.06262 19.9964 3.62523C19.9964 4.18784 19.7729 4.7274 19.3751 5.12523L10.3621 14.1392C10.1246 14.3765 9.8313 14.5501 9.50909 14.6442L6.63609 15.4842C6.55005 15.5093 6.45883 15.5108 6.372 15.4886C6.28517 15.4663 6.20592 15.4212 6.14254 15.3578C6.07916 15.2944 6.03398 15.2151 6.01174 15.1283C5.98949 15.0415 5.991 14.9503 6.01609 14.8642L6.85609 11.9912C6.95062 11.6693 7.12463 11.3763 7.36209 11.1392L16.3751 2.12523Z" stroke="#7D7D7D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button id="closeModalTransferBtn" class="text-gray-500 hover:text-gray-700 text-[32px]" onclick="taskManager.closeModalShow('modalShow')">&times;</button>
            </div>
        </div>
        <div id="modalShowBody" class="py-5 px-8 space-y-3 mx-auto items-center justify-center flex flex-col">

        </div>
    </div>
</div>

<div id="modalEdit"
    class="fixed inset-0 z-[999] flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md h-fit pb-10">
        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b px-4">
            <h2 class="text-md font-semibold">Edit Task</h2>
            <button class="text-gray-500 hover:text-gray-700 text-[32px]" onclick="taskManager.closeModalShow('modalEdit')">&times;</button>
        </div>
        <div id="modalEditBody" class="">

        </div>
    </div>
</div>
@vite('resources/js/task.js')
