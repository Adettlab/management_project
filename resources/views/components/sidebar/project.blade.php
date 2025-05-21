@props(['active', 'expanded' => false])
<div class="group w-full mb-3 flex items-center z-50 cursor-pointer hover:bg-blue-400 rounded-full {{ $active === 'projects' ? 'bg-blue-300' : '' }}"
    onclick="window.location.href='{{ route('projects.index') }}'">
    <a href="{{ route('projects.index') }}"
        class="p-2 flex items-center justify-center z-50 hover:z-50 rounded-full cursor-pointer group-hover:bg-blue-400 group-hover:text-white rounded-full {{ $active === 'projects' ? 'bg-blue-300' : 'bg-white' }}">
        <svg class="size-6" viewBox="0 0 35 35" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M30.0781 3.82812H4.92188C4.31689 3.82812 3.82812 4.31689 3.82812 4.92188V30.0781C3.82812 30.6831 4.31689 31.1719 4.92188 31.1719H30.0781C30.6831 31.1719 31.1719 30.6831 31.1719 30.0781V4.92188C31.1719 4.31689 30.6831 3.82812 30.0781 3.82812ZM12.5781 25.4297C12.5781 25.5801 12.4551 25.7031 12.3047 25.7031H9.57031C9.41992 25.7031 9.29688 25.5801 9.29688 25.4297V9.57031C9.29688 9.41992 9.41992 9.29688 9.57031 9.29688H12.3047C12.4551 9.29688 12.5781 9.41992 12.5781 9.57031V25.4297ZM19.1406 15.8594C19.1406 16.0098 19.0176 16.1328 18.8672 16.1328H16.1328C15.9824 16.1328 15.8594 16.0098 15.8594 15.8594V9.57031C15.8594 9.41992 15.9824 9.29688 16.1328 9.29688H18.8672C19.0176 9.29688 19.1406 9.41992 19.1406 9.57031V15.8594ZM25.7031 18.3203C25.7031 18.4707 25.5801 18.5938 25.4297 18.5938H22.6953C22.5449 18.5938 22.4219 18.4707 22.4219 18.3203V9.57031C22.4219 9.41992 22.5449 9.29688 22.6953 9.29688H25.4297C25.5801 9.29688 25.7031 9.41992 25.7031 9.57031V18.3203Z"
                class="{{ $active === 'projects' ? 'fill-white' : 'fill-gray-600' }} group-hover:fill-white" />
        </svg>
    </a>

    <!-- Label  -->
    <a href="{{ route('projects.index') }}"
        class="ml-1 pr-2 text-sm font-medium group-hover:text-white {{ $active === 'projects' ? 'text-white' : '' }}">
        Project
    </a>
</div>
