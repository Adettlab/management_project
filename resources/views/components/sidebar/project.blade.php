@props(['active', 'expanded' => false])
<div class="group flex items-center z-50 cursor-pointer {{ $active === 'projects' ? 'bg-sky-blue' : 'bg-white' }}"
    :class="{
        'justify-center rounded-full': !
            sidebarExpanded,
        'hover:bg-[#6FAEC9] hover:text-white rounded-full': sidebarExpanded
    }"
    onclick="window.location.href='{{ route('projects.index') }}'">
    <a href="{{ route('projects.index') }}"
        class="bg-secondary-white p-2 flex items-center justify-center z-50 hover:z-50 rounded-full cursor-pointer group-hover:bg-[#6FAEC9] {{ $active === 'projects' ? 'bg-sky-blue' : 'bg-white' }}"
        :class="{ 'group-hover:text-white rounded-full': sidebarExpanded, 'rounded-full': !sidebarExpanded }">
        <svg class="size-6" viewBox="0 0 35 35" fill="{{ $active === 'projects' ? '#FFFFFF' : '#616161' }}"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M30.0781 3.82812H4.92188C4.31689 3.82812 3.82812 4.31689 3.82812 4.92188V30.0781C3.82812 30.6831 4.31689 31.1719 4.92188 31.1719H30.0781C30.6831 31.1719 31.1719 30.6831 31.1719 30.0781V4.92188C31.1719 4.31689 30.6831 3.82812 30.0781 3.82812ZM12.5781 25.4297C12.5781 25.5801 12.4551 25.7031 12.3047 25.7031H9.57031C9.41992 25.7031 9.29688 25.5801 9.29688 25.4297V9.57031C9.29688 9.41992 9.41992 9.29688 9.57031 9.29688H12.3047C12.4551 9.29688 12.5781 9.41992 12.5781 9.57031V25.4297ZM19.1406 15.8594C19.1406 16.0098 19.0176 16.1328 18.8672 16.1328H16.1328C15.9824 16.1328 15.8594 16.0098 15.8594 15.8594V9.57031C15.8594 9.41992 15.9824 9.29688 16.1328 9.29688H18.8672C19.0176 9.29688 19.1406 9.41992 19.1406 9.57031V15.8594ZM25.7031 18.3203C25.7031 18.4707 25.5801 18.5938 25.4297 18.5938H22.6953C22.5449 18.5938 22.4219 18.4707 22.4219 18.3203V9.57031C22.4219 9.41992 22.5449 9.29688 22.6953 9.29688H25.4297C25.5801 9.29688 25.7031 9.41992 25.7031 9.57031V18.3203Z"
                class="{{ $active === 'projects' ? 'fill-[#FFFFFF]' : 'fill-[#616161]' }} group-hover:fill-[#FFFFFF]" />
        </svg>
    </a>

    <!-- Label - Shows when sidebar is expanded or on hover when collapsed -->
    <a href="{{ route('projects.index') }}" x-show="sidebarExpanded"
        class="ml-1 pr-2 text-gray-700 text-sm font-medium {{ $active === 'projects' ? 'text-white' : '' }}"
        :class="{ 'group-hover:text-white': sidebarExpanded }">
        Project
    </a>

    <!-- Tooltip - Shows only on hover when sidebar is collapsed -->
    <div style="z-index: 999;" x-show="!sidebarExpanded"
        class="hidden group-hover:block text-sm text-white text-center w-32 py-[2px] rounded-md absolute bg-sky-blue left-24">
        Project
    </div>
</div>
