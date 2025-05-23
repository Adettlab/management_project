{{-- @props(['active'])
<div class="group flex items-center">
    <a class="bg-secondary-white p-2 flex items-center justify-center rounded-full cursor-pointer hover:bg-[#6FAEC9] {{ $active === 'admin' ? 'bg-sky-blue' : 'bg-white' }}"
        href="{{ route('admin.index') }}">
        <svg class="size-6" viewBox="0 0 35 35" xmlns="http://www.w3.org/2000/svg">
            <path class="{{ $active === 'admin' ? 'fill-[#FFFFFF]' : 'fill-[#616161]' }} group-hover:fill-[#FFFFFF]"
        </svg>
    </a>
    <div
        class="hidden group-hover:block text-sm text-white ml-14 text-center w-32 py-[2px] rounded-md absolute bg-sky-blue bg-white z-50">
        Admin
    </div>
</div> --}}

@props(['active'])
<div class="sidebar-item flex items-center w-full {{ $active === 'admin' ? 'active' : '' }}" data-tooltip="Admin">
    <a href="{{ route('admin.index') }}"
        class="flex items-center p-2 rounded-lg transition-colors w-full group
        {{ $active === 'admin' ? 'active' : '' }}">
        <svg class="sidebar-icon size-6 flex-shrink-0" viewBox="0 0 35 35" xmlns="http://www.w3.org/2000/svg">
            <path class="{{ $active === 'admin' ? 'active' : '' }}"
                d="M17.5 1.4585L4.375 7.29183V16.0418C4.375 24.1356 9.975 31.7043 17.5 33.5418C25.025 31.7043 30.625 24.1356 30.625 16.0418V7.29183L17.5 1.4585ZM17.5 7.146C18.3653 7.146 19.2112 7.40259 19.9306 7.88332C20.6501 8.36405 21.2108 9.04733 21.542 9.84676C21.8731 10.6462 21.9597 11.5258 21.7909 12.3745C21.6221 13.2232 21.2054 14.0027 20.5936 14.6146C19.9817 15.2264 19.2022 15.6431 18.3535 15.8119C17.5049 15.9807 16.6252 15.8941 15.8258 15.563C15.0263 15.2318 14.3431 14.6711 13.8623 13.9516C13.3816 13.2322 13.125 12.3863 13.125 11.521C13.125 10.3607 13.5859 9.24788 14.4064 8.4274C15.2269 7.60693 16.3397 7.146 17.5 7.146ZM17.5 18.6668C20.4167 18.6668 26.25 20.2564 26.25 23.1585C25.2922 24.6024 23.992 25.7869 22.4652 26.6062C20.9385 27.4256 19.2327 27.8544 17.5 27.8544C15.7673 27.8544 14.0615 27.4256 12.5348 26.6062C11.008 25.7869 9.70779 24.6024 8.75 23.1585C8.75 20.2564 14.5833 18.6668 17.5 18.6668Z" />
        </svg>
        <span class="sidebar-label text-sm font-medium whitespace-nowrap hidden">
            Admin
        </span>
    </a>
</div>
