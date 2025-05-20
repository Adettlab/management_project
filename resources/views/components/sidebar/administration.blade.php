@props(['active', 'expanded' => false])
<div class="group flex items-center z-50 cursor-pointer {{ $active === 'administration' ? 'bg-sky-blue' : 'bg-white' }}"
    :class="{
        'justify-center rounded-full': !
            sidebarExpanded,
        'hover:bg-[#6FAEC9] hover:text-white rounded-full': sidebarExpanded
    }"
    onclick="window.location.href='{{ route('administration.index') }}'">
    <a class="bg-secondary-white p-2 flex items-center justify-center rounded-full cursor-pointer group-hover:bg-[#6FAEC9] {{ $active === 'administration' ? 'bg-sky-blue' : 'bg-white' }}"
        href="{{ route('administration.index') }}"
        :class="{ 'group-hover:text-white rounded-full': sidebarExpanded, 'rounded-full': !sidebarExpanded }">
        <svg class="size-6" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                class="{{ $active === 'administration' ? 'fill-[#FFFFFF]' : 'fill-[#616161]' }} group-hover:fill-[#FFFFFF]"
                d="M10.2083 2.9165C8.66124 2.9165 7.17751 3.53109 6.08354 4.62505C4.98958 5.71901 4.375 7.20274 4.375 8.74984V26.2498C4.375 27.7969 4.98958 29.2807 6.08354 30.3746C7.17751 31.4686 8.66124 32.0832 10.2083 32.0832H30.625V2.9165H10.2083ZM16.0417 7.2915H26.25V10.2082H16.0417V7.2915ZM7.29167 26.2498C7.29167 25.4763 7.59896 24.7344 8.14594 24.1874C8.69292 23.6405 9.43479 23.3332 10.2083 23.3332H27.7083V29.1665H10.2083C9.43479 29.1665 8.69292 28.8592 8.14594 28.3122C7.59896 27.7653 7.29167 27.0234 7.29167 26.2498Z" />
        </svg>
    </a>
     <!-- Label - Shows when sidebar is expanded or on hover when collapsed -->
    <a href="{{ route('administration.index') }}" x-show="sidebarExpanded"
        class="ml-1 pr-2 text-gray-700 text-sm font-medium {{ $active === 'administration' ? 'text-white' : '' }}"
        :class="{ 'group-hover:text-white': sidebarExpanded }">
        Administration
    </a>

    <!-- Tooltip - Shows only on hover when sidebar is collapsed -->
    <div style="z-index: 999;" x-show="!sidebarExpanded"
        class="hidden group-hover:block text-sm text-white text-center w-32 py-[2px] rounded-md absolute bg-sky-blue left-24">
        Administration
    </div>
</div>
