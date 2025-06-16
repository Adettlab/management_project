<x-layouts.layout :title="$title" :active="$active">
    <!-- Main Content -->
    <main class="sm:h-[80vh] xs:h-100 flex sm:flex-row xs:flex-col-reverse">
        <div class="flex sm:w-7/12 xs:w-[100%] sm:m-0 xs:m-auto">
            {{-- Status SDM start --}}
            <div class="sm:border h-full w-full flex flex-col rounded-2xl sm:bg-white xs:bg-primary-white p-4">
                <div class="flex sm:justify-between xs:justify-between">
                    <button id="ready-btn"
                        class="status-btn border text-black sm:py-[3px] xss:py-[7px] xs:py-[6px] xs:text-[9px] xss:text-[11px] sm:text-base font-medium rounded-lg sm:w-[100px] xss:w-[78px] xs:w-[65px] text-center hover:hover:bg-black hover:text-white bg-black text-white"
                        data-content="Ready" onclick="filterByStatus('ready')" data-status="ready">Ready</button>
                    <button id="standby-btn"
                        class="status-btn border text-black sm:py-[3px] xss:py-[7px] xs:py-[6px] xs:text-[9px] xss:text-[11px] sm:text-base font-medium rounded-lg sm:w-[100px] xss:w-[78px] xs:w-[65px] text-center hover:bg-black hover:text-white"
                        data-content="Standby" onclick="filterByStatus('Stand By')" data-status="Stand By">Stand
                        by</button>
                    <button id="not-ready-btn"
                        class="status-btn border text-black sm:py-[3px] xss:py-[7px] xs:py-[6px] xs:text-[9px] xss:text-[11px] sm:text-base font-medium rounded-lg sm:w-[100px] xss:w-[78px] xs:w-[65px] text-center hover:bg-black hover:text-white"
                        data-content="Not Ready" onclick="filterByStatus('not ready')" data-status="not ready">Not
                        Ready</button>
                    <button id="attend-btn"
                        class="status-btn border text-black sm:py-[3px] xss:py-[7px] xs:py-[6px] xs:text-[9px] xss:text-[11px] sm:text-base font-medium rounded-lg sm:w-[100px] xss:w-[78px] xs:w-[65px] text-center hover:bg-black hover:text-white"
                        data-content="Attend" onclick="filterByStatus('Completed')"
                        data-status="Completed">Completed</button>
                    <button id="absent-btn"
                        class="status-btn border text-black sm:py-[3px] xss:py-[7px] xs:py-[6px] xs:text-[9px] xss:text-[11px] sm:text-base font-medium rounded-lg sm:w-[100px] xss:w-[78px] xs:w-[65px] text-center hover:bg-black hover:text-white"
                        data-content="Absent" onclick="filterByStatus('absent')" data-status="absent">Absent</button>
                </div>
                <div class="h-[calc(100vh-200px)] overflow-y-auto mt-2">
                    <div class="grid sm:grid-cols-3 gap-3 mt-5">
                        @forelse ($employees as $index => $employee)
                            @if (strtolower($filter) == 'ready' || strtolower($filter) == 'completed')
                                @php
                                    $firstTask = $employee->projects
                                        ->flatMap(function ($project) use ($employee) {
                                            return $project->tasks->filter(function ($task) use ($employee) {
                                                return optional($task->assignedProjectEmployee)->employee_id ===
                                                    $employee->id;
                                            });
                                        })
                                        ->first();
                                @endphp
                                <div
                                    class="border xs:shadow-[0_0_0_0.5px_rgba(0,0,0,0.15)] sm:shadow-none rounded-md sm:p-4 xs:p-3 xs:m-auto sm:m-0 h-fit sm:w-auto xs:w-[100%] max-h-full sm:block xs:grid xs:grid-rows-2 xs:grid-flow-col xs:relative">
                                    <div class="flex xs:items-center">
                                        @if ($employee->photo)
                                            <img src="{{ asset('/storage/' . $employee->photo) }}" alt="Photo"
                                                class="w-12 h-12 rounded-full object-cover" loading="lazy">
                                        @else
                                            <div
                                                class="sm:w-12 sm:h-12 xs:w-10 xs:h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                                <img src="{{ asset('blank_profile.png') }}" alt="Photo"
                                                    class="w-9 h-9 rounded-full object-cover" loading="lazy">
                                            </div>
                                        @endif
                                        <div class="flex flex-col justify-center ml-2">
                                            <p class="font-semibold sm:text-sm xs:text-[12px]">
                                                {{ $employee->user->name }}</p>
                                            <p class="sm:text-xs primary-gray xs:text-[11px] xs:-mt-0.5 sm:mt-0">
                                                {{ $employee->role->name }}</p>
                                        </div>
                                    </div>
                                    <p
                                        class="sm:text-sm xs:text-[12px] font-black mt-2 sm:static xs:absolute xs:bottom-7 xs:left-[18px]">
                                        Working on
                                        {{ $employee->projects->firstWhere('id', $firstTask->project_id)->name }} :
                                    </p>
                                    <div>
                                        @if ($firstTask)
                                            <div
                                                class="sm:text-xs xs:text-[11px] primary-gray font-medium mb-8 mt-2 sm:static xs:absolute xs:-bottom-5 xs:left-5">
                                                {{ $firstTask->name }}
                                            </div>
                                            <div
                                                class="flex mt-3 gap-x-2 xs:absolute sm:static xs:right-3 xs:top-[3px]">
                                                <p
                                                    class="px-3 py-1 rounded-md font-medium sm:text-xs xs:text-[10px] {{ strtolower($firstTask->taskStatus->name) === 'completed' ? 'bg-primary-green text-white' : 'bg-secondary-white primary-gray' }}">
                                                    {{ $firstTask->taskStatus->name }}
                                                </p>
                                                <p style="background-color: {{ $firstTask->taskLevel->color }}"
                                                    class="sm:text-xs xs:text-[10px] px-3 py-1 rounded-md text-white font-medium">
                                                    {{ $firstTask->taskLevel->name }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @elseif (strtolower($filter) == 'absent')
                                <div
                                    class="border rounded-md p-4 h-fit max-h-full xs:shadow-[0_0_0_0.5px_rgba(0,0,0,0.15)] sm:shadow-none">
                                    <div class="flex">
                                        @if ($employee->photo)
                                            <img src="{{ asset('/storage/' . $employee->photo) }}" alt="Photo"
                                                class="sm:w-12 sm:h-12 xs:w-11 xs:h-11 rounded-full object-cover"
                                                loading="lazy">
                                        @else
                                            <div
                                                class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                                <img src="{{ asset('blank_profile.png') }}" alt="Photo"
                                                    class="sm:w-9 sm:h-9 xs:w-8 xs:h-8 rounded-full object-cover"
                                                    loading="lazy">
                                            </div>
                                        @endif
                                        <div class="flex flex-col justify-center ml-2">
                                            <p class="font-semibold sm:text-sm xs:text-[12px]">
                                                {{ $employee->user->name }}</p>
                                            <p class="sm:text-xs xs:text-[11px] primary-gray">
                                                {{ \Carbon\Carbon::parse($employee->administration->start_date)->diffInDays($employee->administration->end_date) + 1 }}
                                                day off
                                            </p>
                                        </div>
                                    </div>
                                    <p class="sm:text-sm xs:text-[12px] font-black mt-2 mb-2">
                                        {{ $employee->administration->leavecategory->name }}
                                    </p>
                                    <div>
                                        <p class="sm:text-xs xs:text-[11px] w-fit">
                                            {{ $employee->administration->description }}</p>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="border rounded-md p-2 xs:shadow-[0_0_0_0.5px_rgba(0,0,0,0.15)] sm:shadow-none max-h-full h-fit">
                                    <div class="flex">
                                        @if ($employee->photo)
                                            <img src="{{ asset('/storage/' . $employee->photo) }}" alt="Photo"
                                                class="sm:w-12 sm:h-12 xs:w-11 xs:h-11 rounded-full object-cover"
                                                loading="lazy">
                                        @else
                                            <div
                                                class="sm:w-12 sm:h-12 xs:w-11 xs:h-11 rounded-full bg-gray-100 flex items-center justify-center">
                                                <img src="{{ asset('blank_profile.png') }}" alt="Photo"
                                                    class="sm:w-9 sm:h-9 xs:w-8 xs:h-8 rounded-full object-cover"
                                                    loading="lazy">
                                            </div>
                                        @endif
                                        <div class="flex flex-col justify-center ml-2">
                                            <p class="font-semibold sm:text-sm xs:text-[12px]">
                                                {{ $employee->user->name }}</p>
                                            <p class="sm:text-xs xs:text-[11px] primary-gray">
                                                {{ $employee->role->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div>
                                <p colspan="4" class="text-center border-gray-300">No employees found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            {{-- Status SDM end --}}
        </div>
        <div class="sm:w-5/12 xs:w-[100%] sm:ml-3 sm:block xs:flex xs:items-center overflow-x-auto">
            <div class="flex sm:h-3/5 w-auto xs:h-[23vh] space-x-3 xs:px-3 sm:px-0 pb-2">
                {{-- Tasks start --}}
                <div
                    class="bg-primary-green border rounded-2xl rounded px-3 py-3 primary-white sm:w-1/2 xs:w-[65vw] overflow-x-auto overflow-y-hidden">
                    <div class="font-medium sm:text-base xs:text-[14px] flex gap-x-1 items-center">
                        <div>
                            <svg class="sm:size-[22px] xs:size-[20px]" viewBox="0 0 35 35" fill="#fcfcfc"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20.4154 2.9165H8.7487C7.14453 2.9165 5.84661 4.229 5.84661 5.83317L5.83203 29.1665C5.83203 30.7707 7.12995 32.0832 8.73411 32.0832H26.2487C27.8529 32.0832 29.1654 30.7707 29.1654 29.1665V11.6665L20.4154 2.9165ZM15.9529 26.2498L10.7904 21.0873L12.8466 19.0311L15.9383 22.1228L22.1216 15.9394L24.1779 17.9957L15.9529 26.2498ZM18.957 13.1248V5.104L26.9779 13.1248H18.957Z" />
                            </svg>
                        </div>
                        Tasks
                    </div>
                    <div class="flex-row space-y-2 mt-2 items-center justify-center h-full max-h-full pb-10 overflow-y-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
                        id="taskContainer">
                        @forelse ($tasksnprojects['tasks'] as $task)
                            <div class="bg-white h-fit w-full border-0 px-3 py-2 rounded-md sm:space-y-4 xs:space-y-2">
                                <p class="text-black sm:text-sm xs:text-[12px] font-bold">{{ $task->name }}</p>

                                <p class="text-gray-400 sm:text-xs xs:text-[11px]">
                                    {{ \Carbon\Carbon::parse($task->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </p>
                                <div class="flex justify-between items-start">
                                    <p class="sm:text-[10px] xs:text-[8px] font-medium px-2 py-[2px] rounded-md text-white"
                                        style="background-color: {{ $task->tasklevel->color }}">
                                        {{ $task->tasklevel->name }}</p>
                                    @if ($task->accepted)
                                        <p
                                            class="sm:text-[10px] xs:text-[8px] font-medium px-2 py-[8px] rounded-md text-black bg-zinc-200 border shadow">
                                            Accepted</p>
                                    @else
                                        <div id="accepted" class="flex items-center">
                                            <button
                                                class="sm:text-[10px] xs:text-[8px] font-medium px-2 py-[2px] rounded-md text-white bg-red-500 border shadow"
                                                onclick="updateAccept({{ $task->id }})">Accept</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="mx-auto h-full flex justify-center items-center" id="notask">you have 0 tasks
                            </p>
                        @endforelse
                    </div>
                </div>
                {{-- Tasks end --}}
                {{-- Project start --}}
                <div
                    class="bg-primary-orange border rounded-2xl rounded px-3 py-3 primary-white sm:w-1/2 xs:w-[65vw] overflow-x-auto overflow-y-hidden">
                    <div class="font-medium text-base flex gap-x-1 items-center">
                        <div>
                            <svg class="sm:size-[22px] xs:size-[20px]" viewBox="0 0 35 35" fill="#fcfcfc"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M30.0781 3.82812H4.92188C4.31689 3.82812 3.82812 4.31689 3.82812 4.92188V30.0781C3.82812 30.6831 4.31689 31.1719 4.92188 31.1719H30.0781C30.6831 31.1719 31.1719 30.6831 31.1719 30.0781V4.92188C31.1719 4.31689 30.6831 3.82812 30.0781 3.82812ZM12.5781 25.4297C12.5781 25.5801 12.4551 25.7031 12.3047 25.7031H9.57031C9.41992 25.7031 9.29688 25.5801 9.29688 25.4297V9.57031C9.29688 9.41992 9.41992 9.29688 9.57031 9.29688H12.3047C12.4551 9.29688 12.5781 9.41992 12.5781 9.57031V25.4297ZM19.1406 15.8594C19.1406 16.0098 19.0176 16.1328 18.8672 16.1328H16.1328C15.9824 16.1328 15.8594 16.0098 15.8594 15.8594V9.57031C15.8594 9.41992 15.9824 9.29688 16.1328 9.29688H18.8672C19.0176 9.29688 19.1406 9.41992 19.1406 9.57031V15.8594ZM25.7031 18.3203C25.7031 18.4707 25.5801 18.5938 25.4297 18.5938H22.6953C22.5449 18.5938 22.4219 18.4707 22.4219 18.3203V9.57031C22.4219 9.41992 22.5449 9.29688 22.6953 9.29688H25.4297C25.5801 9.29688 25.7031 9.41992 25.7031 9.57031V18.3203Z" />
                            </svg>
                        </div>
                        projects
                    </div>
                    <div
                        class="flex-row sm:space-y-2 xs:space-y-1 mt-2 items-center justify-center h-full max-h-full pb-10 overflow-y-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                        @forelse ($tasksnprojects['projects'] as $project)
                            <div class="bg-white mb-2 w-full border-0 px-3 py-2 rounded-md">
                                <p class="text-black sm:text-sm xs:text-[12px] font-bold">{{ $project->name }}</p>
                                <p class="text-gray-400 sm:text-xs xs:text-[11px] mt-2">
                                    {{ \Carbon\Carbon::parse($project->start_date)->locale('id')->isoFormat('D MMMM YYYY') }}
                                    -
                                    {{ \Carbon\Carbon::parse($project->end_date)->locale('id')->isoFormat('D MMMM YYYY') }}
                                </p>
                                <p class="text-gray-400 text-xs mt-2">{{ $project->description }}</p>
                                <div class="flex justify-between items-start mt-2">
                                    <p class="sm:text-[10px] xs:text-[8px] font-medium px-2 py-[2px] rounded-md text-white"
                                        style="background-color: {{ $project->status->color }}">
                                        {{ $project->status->name }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="h-full flex justify-center items-center">There's no project</p>
                        @endforelse
                    </div>
                </div>
                {{-- Project end --}}
            </div>
            <div class="h-2/5 hidden sm:block">
                {{-- Activity start --}}
                <div class="bg-white rounded-2xl rounded border px-3 py-3 h-full">
                    <div class="font-medium text-base items-center flex gap-x-1 primary-gray">
                        <div>
                            <svg class="size-[22px]" viewBox="0 0 35 35" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.1529 3.53063C12.0138 3.28125 14.3938 3.28125 17.4169 3.28125H17.5831C20.6063 3.28125 22.9863 3.28125 24.8456 3.53063C26.756 3.78729 28.2785 4.32542 29.4758 5.52417C30.6746 6.72146 31.2113 8.24542 31.4694 10.1529C31.7188 12.0138 31.7188 14.3938 31.7188 17.4169V17.5831C31.7188 20.6063 31.7188 22.9863 31.4694 24.8456C31.2127 26.756 30.6746 28.2785 29.4758 29.4758C28.2785 30.6746 26.7546 31.2113 24.8471 31.4694C22.9862 31.7188 20.6063 31.7188 17.5831 31.7188H17.4169C14.3938 31.7188 12.0138 31.7188 10.1544 31.4694C8.24396 31.2127 6.72146 30.6746 5.52417 29.4758C4.32542 28.2785 3.78875 26.7546 3.53063 24.8471C3.28125 22.9862 3.28125 20.6063 3.28125 17.5831V17.4169C3.28125 14.3938 3.28125 12.0138 3.53063 10.1544C3.78729 8.24396 4.32542 6.72146 5.52417 5.52417C6.72146 4.32542 8.24542 3.78875 10.1529 3.53063ZM17.1135 9.99396C17.0671 9.76322 16.9474 9.55363 16.7724 9.39631C16.5973 9.23899 16.3761 9.14235 16.1418 9.12073C15.9074 9.09911 15.6723 9.15367 15.4714 9.27631C15.2705 9.39894 15.1146 9.58311 15.0267 9.80146L12.3842 16.4062H10.2083C9.91825 16.4062 9.64005 16.5215 9.43494 16.7266C9.22982 16.9317 9.11458 17.2099 9.11458 17.5C9.11458 17.7901 9.22982 18.0683 9.43494 18.2734C9.64005 18.4785 9.91825 18.5938 10.2083 18.5938H13.125C13.3436 18.5936 13.5571 18.5279 13.738 18.4052C13.919 18.2825 14.059 18.1084 14.14 17.9054L15.6902 14.0306L17.8865 25.006C17.9329 25.2368 18.0526 25.4464 18.2276 25.6037C18.4027 25.761 18.6239 25.8577 18.8582 25.8793C19.0926 25.9009 19.3277 25.8463 19.5286 25.7237C19.7295 25.6011 19.8855 25.4169 19.9733 25.1985L22.6158 18.5938H24.7917C25.0817 18.5938 25.3599 18.4785 25.5651 18.2734C25.7702 18.0683 25.8854 17.7901 25.8854 17.5C25.8854 17.2099 25.7702 16.9317 25.5651 16.7266C25.3599 16.5215 25.0817 16.4062 24.7917 16.4062H21.875C21.6566 16.4063 21.4432 16.4718 21.2623 16.5942C21.0814 16.7166 20.9413 16.8904 20.86 17.0931L19.3083 20.9708L17.1135 9.99396Z"
                                    fill="#616161" />
                            </svg>
                        </div>
                        {{-- Activity --}}
                    </div>
                    <div class="flex items-center justify-center h-full pb-8">
                        <canvas id="canvasActivity" class="w-full h-full px-2 text-xl mt-4">
                        </canvas>
                    </div>
                </div>
                {{-- Activity end --}}
            </div>
        </div>
    </main>
</x-layouts.layout>
@vite('resources/js/chart.js')
<script>
    const basepath = window.location.pathname.split('/dashboard')[0];
    const taskContainer = document.getElementById('taskContainer');
    const employeeId = @js(auth()->user()->employee ? auth()->user()->employee->id : '');
    window.employeeID = employeeId;
    const notask = document.getElementById('notask');
    window.yearActivity = @js($yearActivity);
    let retryCount = 0;
    let eventsource = null;

    function filterByStatus(status) {
        const url = new URL(window.location.href);
        url.searchParams.set('status', status);
        window.location.href = url.toString();
    }

    function appendTaskToDOM(task) {
        if (notask) {
            notask.remove();
        }
        const taskContainer = document.getElementById('taskContainer');

        // Create the task element
        const taskElement = document.createElement('div');
        taskElement.className = 'bg-white h-fit w-full border-0 px-3 py-2 rounded-md space-y-4';

        // Add task name
        const taskName = document.createElement('p');
        taskName.className = 'text-black text-sm font-bold';
        taskName.textContent = task.task.task.name;
        taskElement.appendChild(taskName);
        // Add task creation date

        const taskDate = document.createElement('p');
        taskDate.className = 'text-gray-400 text-xs';
        taskDate.textContent = new Date(task.task.task.created_at).toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        taskElement.appendChild(taskDate);

        // Add task level
        const taskLevel = document.createElement('div');
        taskLevel.className = 'flex justify-between items-start';

        const levelBadge = document.createElement('p');
        levelBadge.className = 'text-[10px] font-medium px-2 py-[2px] rounded-md text-white';
        levelBadge.style.backgroundColor = task.task.task.task_level.color;
        levelBadge.textContent = task.task.task.task_level.name;
        taskLevel.appendChild(levelBadge);

        taskElement.appendChild(taskLevel);

        taskContainer.appendChild(taskElement);
    }

    function setActiveStatus(button) {
        const content = document.getElementById('status-content');
        if (content) {
            content.textContent = button.getAttribute('data-content');
        }
        // Reset semua tombol ke status default
        document.querySelectorAll('.status-btn').forEach(btn => {
            btn.classList.remove('bg-black', 'text-white');
        });
        // Tambahkan class Tailwind ke tombol yang aktif
        button.classList.add('bg-black', 'text-white');
        const url = new URL(window.location.href);
        url.searchParams.set('status', button.getAttribute('data-status'));
        window.history.pushState({}, '', url.toString());
    }

    // Inisialisasi default ke tombol "Ready"
    window.addEventListener('DOMContentLoaded', () => {
        if (employeeId) {
            //streamTaskNotification();
        }
        const params = new URLSearchParams(window.location.search);
        const stat = params.get('status') || 'ready';
        const activeButton = document.querySelector(`[data-status="${stat}"]`);
        if (activeButton) {
            setActiveStatus(activeButton);
        }
    });

    // Tambahkan event listener ke semua tombol
    document.querySelectorAll('.status-btn').forEach(button => {
        button.addEventListener('click', function() {
            setActiveStatus(this);
        });
    });

    async function updateAccept(id) {
        console.log('this one is clicked')
        const accepted = document.getElementById('accepted');
        const response =
            `<p class="sm:text-[10px] xs:text-[8px] font-medium px-2 py-[2px] rounded-md text-black bg-zinc-200 border shadow">Accepted</p>`
        await fetch(`${basepath}/tasks/accepted/${id}`, {
            method: "POST",
            headers: {
                'content-type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        }).then(res => {
            if (res.ok) {
                accepted.removeChild(accepted.firstElementChild);
                accepted.innerHTML = response;
            }
        })
    }
</script>
