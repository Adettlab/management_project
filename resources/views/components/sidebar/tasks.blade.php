@props(['active', 'expanded' => false])
<div class="group flex items-center z-50 cursor-pointer {{ $active === 'tasks' ? 'bg-sky-blue' : 'bg-white' }}"
    :class="{
        'justify-center rounded-full': !
            sidebarExpanded,
        'hover:bg-[#6FAEC9] hover:text-white rounded-full': sidebarExpanded
    }"
    onclick="window.location.href='{{ route('tasks.index') }}'">
    <a class="bg-secondary-white p-2 flex items-center justify-center rounded-full cursor-pointer group-hover:bg-[#6FAEC9] {{ $active === 'tasks' ? 'bg-sky-blue' : 'bg-white' }}"
        :class="{ 'group-hover:text-white rounded-full': sidebarExpanded, 'rounded-full': !sidebarExpanded }"
        href="{{ route('tasks.index') }}">
        <svg class="size-6" viewBox="0 0 35 35" fill="{{ $active === 'tasks' ? '#FFFFFF' : '#616161' }}"
            xmlns="http://www.w3.org/2000/svg">
            <path class="{{ $active === 'tasks' ? 'fill-[#FFFFFF]' : 'fill-[#616161]' }} group-hover:fill-[#FFFFFF]"
                d="M20.4154 2.9165H8.7487C7.14453 2.9165 5.84661 4.229 5.84661 5.83317L5.83203 29.1665C5.83203 30.7707 7.12995 32.0832 8.73411 32.0832H26.2487C27.8529 32.0832 29.1654 30.7707 29.1654 29.1665V11.6665L20.4154 2.9165ZM15.9529 26.2498L10.7904 21.0873L12.8466 19.0311L15.9383 22.1228L22.1216 15.9394L24.1779 17.9957L15.9529 26.2498ZM18.957 13.1248V5.104L26.9779 13.1248H18.957Z" />
        </svg>
    </a>

    <!-- Label - Shows when sidebar is expanded or on hover when collapsed -->
    <a href="{{ route('tasks.index') }}" x-show="sidebarExpanded"
        class="ml-1 pr-2 text-gray-700 text-sm font-medium {{ $active === 'tasks' ? 'text-white' : '' }}"
        :class="{ 'group-hover:text-white': sidebarExpanded }">
        Task
    </a>

    <!-- Tooltip - Shows only on hover when sidebar is collapsed -->
    <div style="z-index: 999;" x-show="!sidebarExpanded"
        class="hidden group-hover:block text-sm text-white text-center w-32 py-[2px] rounded-md absolute bg-sky-blue left-24">
        Task
    </div>
</div>
