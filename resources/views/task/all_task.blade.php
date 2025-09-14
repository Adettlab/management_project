<x-layouts.layout :title="$title" :active="$active">
    <main class="max-w-screen w-full mx-auto rounded-xl bg-white border">
        <!-- Search and Add Button -->
        <div class="flex items-center justify-between mb-4 pt-8 pr-6">
            <form action="" method="GET" class="w-full sm:w-1/2 flex mr-3">
                <div class="ml-5 w-[60%] sm:w-[25%]">
                    <select name="task_level"
                        class="w-full sm:w-[94%] primary-gray font-medium rounded-lg py-2 px-2 text-sm border outline-none"
                        onchange="this.form.submit()">
                        <option value="">Task Level</option>
                        <option value="low" {{ request('task_level') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('task_level') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('task_level') == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
                <div class="ml-1 sm:ml-5 w-[60%] sm:w-[25%]">
                    <select name="task_status"
                        class="w-full sm:w-[94%] primary-gray font-medium rounded-lg py-2 px-2 text-sm border outline-none"
                        onchange="this.form.submit()">
                        <option value="">Task Status</option>
                        <option value="to-do" {{ request('task_status') == 'to-do' ? 'selected' : '' }}>To-Do</option>
                        <option value="in progress" {{ request('task_status') == 'in progress' ? 'selected' : '' }}>In
                            Progress</option>
                        <option value="review" {{ request('task_status') == 'review' ? 'selected' : '' }}>Review
                        </option>
                        <option value="completed" {{ request('task_status') == 'completed' ? 'selected' : '' }}>Complete
                        </option>
                    </select>
                </div>
            </form>

            <a href="{{ route('tasks.index') }}"
                class="bg-primary-black hover:bg-zinc-500 cursor-pointer text-white text-xs px-4 py-2 rounded-lg hover:bg-gray-800">
                <span class="sm:inline xs:hidden">Task Board View</span>
                <span class="sm:hidden xs:inline">Board</span>
            </a>
        </div>

        <!-- Table -->
        <div
            class="overflow-x-auto xs:mx-5 sm:mx-0 xs:mt-5 sm:mt-0 sm:bg-none xs:bg-white sm:shadow-none xs:shadow-[0_0_6px_rgba(0,0,0,0.1)] sm:rounded-none xs:rounded-t-lg xs:rounded-b-sm">
            <table class="w-full border-collapse sm:bg-none">
                <thead class="bg-[#F9F9F9]">
                    <tr>
                        <th class="w-[2%] pl-4 py-5 primary-gray text-left font-medium sm:text-sm xs:text-[12px]">#</th>
                        <th class="w-[10%] px-4 py-5 primary-gray text-left font-medium sm:text-sm xs:text-[12px]">Task
                            <span class="hidden sm:inline">Name</span>
                        </th>
                        <th class="w-[10%] px-4 py-5 primary-gray text-left font-medium sm:text-sm xs:text-[12px]">
                            Project</th>
                        <th class="w-[10%] px-2 py-5 primary-gray text-left font-medium sm:text-sm xs:text-[12px]"><span
                                class="hidden sm:inline">Assigned</span>
                            Employee
                        </th>
                        <th
                            class="w-[4%] py-5 primary-gray text-left font-medium text-sm text-center hidden sm:table-cell">
                            Task Level
                        </th>
                        <th class="w-[5%] px-4 py-5 primary-gray text-left font-medium text-sm hidden sm:table-cell">
                            Task Status</th>
                        {{-- <th class="w-[6%] py-5 primary-gray text-left font-medium text-sm w-24 hidden sm:table-cell">
                            Created</th> --}}
                        <th class="w-[10%] px-4 py-5 primary-gray text-left font-medium sm:text-sm xs:text-[12px]">
                            Start Date</th>
                        <th class="w-[10%] px-4 py-5 primary-gray text-left font-medium sm:text-sm xs:text-[12px]">
                            End Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Row -->
                    @foreach ($tasks as $index => $task)
                        <tr class="group hover:bg-[#F5F5F5] cursor-pointer font-medium">
                            <td class="pl-4 py-3 sm:text-sm xs:text-[12px]">
                                {{ $tasks->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3 sm:text-sm xs:text-[12px]">
                                {{ $task->name }}
                            </td>
                            <td class="px-4 py-3 sm:text-sm xs:text-[12px]">
                                {{ $task->project->name }}
                            </td>
                            <td class="pl-2 py-3 sm:text-sm xs:text-[12px]">
                                {{ $task->assignedProjectEmployee->employee->user->name }}
                            </td>
                            <td class="py-3 text-sm flex items-center justify-center hidden sm:flex">
                                <p class="text-white text-xs px-2 rounded-md"
                                    style="background-color: {{ $task->taskLevel->color }};">
                                    {{ $task->taskLevel->name }}
                                </p>
                            </td>
                            <td class="px-4 py-3 text-sm hidden sm:table-cell">
                                {{ $task->taskStatus->name }}
                            </td>
                            {{-- <td class="py-3 text-sm hidden sm:table-cell">
                                {{ $task->created_at->format('M j, Y') }}
                            </td> --}}
                            <!-- Start Date -->
                            <td class="px-4 py-3 text-sm">
                                {{ \Carbon\Carbon::parse($task->start_date)->format('M j, Y') }}
                            </td>
                            <!-- End Date -->
                            <td class="px-4 py-3 text-sm">
                                {{ \Carbon\Carbon::parse($task->end_date)->format('M j, Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-between items-center my-5 pl-5">
                {{ $tasks->links() }}
            </div>
        </div>
    </main>
</x-layouts.layout>
