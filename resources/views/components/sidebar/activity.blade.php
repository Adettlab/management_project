@props(['active', 'expanded' => false])
<div class="group flex items-center z-50 cursor-pointer {{ $active === 'activity' ? 'bg-sky-blue' : 'bg-white' }}"
    :class="{
        'justify-center rounded-full': !
            sidebarExpanded,
        'hover:bg-[#6FAEC9] hover:text-white rounded-full': sidebarExpanded
    }"
    onclick="window.location.href='{{ route('activity.index') }}'">
    <a class="bg-secondary-white p-2 flex items-center justify-center rounded-full cursor-pointer group-hover:bg-[#6FAEC9] {{ $active === 'activity' ? 'bg-sky-blue' : 'bg-white' }}"
        href="{{ route('activity.index') }}"
        :class="{ 'group-hover:text-white rounded-full': sidebarExpanded, 'rounded-full': !sidebarExpanded }">
        <svg class="size-6" viewBox="0 0 35 35" fill="{{ $active === 'activity' ? '#FFFFFF' : '#616161' }}"
            xmlns="http://www.w3.org/2000/svg">
            <path class="{{ $active === 'activity' ? 'fill-[#FFFFFF]' : 'fill-[#616161]' }} group-hover:fill-[#FFFFFF]"
                d="M10.1529 3.53063C12.0138 3.28125 14.3938 3.28125 17.4169 3.28125H17.5831C20.6063 3.28125 22.9863 3.28125 24.8456 3.53063C26.756 3.78729 28.2785 4.32542 29.4758 5.52417C30.6746 6.72146 31.2113 8.24542 31.4694 10.1529C31.7188 12.0138 31.7188 14.3938 31.7188 17.4169V17.5831C31.7188 20.6063 31.7188 22.9863 31.4694 24.8456C31.2127 26.756 30.6746 28.2785 29.4758 29.4758C28.2785 30.6746 26.7546 31.2113 24.8471 31.4694C22.9862 31.7188 20.6063 31.7188 17.5831 31.7188H17.4169C14.3938 31.7188 12.0138 31.7188 10.1544 31.4694C8.24396 31.2127 6.72146 30.6746 5.52417 29.4758C4.32542 28.2785 3.78875 26.7546 3.53063 24.8471C3.28125 22.9862 3.28125 20.6063 3.28125 17.5831V17.4169C3.28125 14.3938 3.28125 12.0138 3.53063 10.1544C3.78729 8.24396 4.32542 6.72146 5.52417 5.52417C6.72146 4.32542 8.24542 3.78875 10.1529 3.53063ZM17.1135 9.99396C17.0671 9.76322 16.9474 9.55363 16.7724 9.39631C16.5973 9.23899 16.3761 9.14235 16.1418 9.12073C15.9074 9.09911 15.6723 9.15367 15.4714 9.27631C15.2705 9.39894 15.1146 9.58311 15.0267 9.80146L12.3842 16.4062H10.2083C9.91825 16.4062 9.64005 16.5215 9.43494 16.7266C9.22982 16.9317 9.11458 17.2099 9.11458 17.5C9.11458 17.7901 9.22982 18.0683 9.43494 18.2734C9.64005 18.4785 9.91825 18.5938 10.2083 18.5938H13.125C13.3436 18.5936 13.5571 18.5279 13.738 18.4052C13.919 18.2825 14.059 18.1084 14.14 17.9054L15.6902 14.0306L17.8865 25.006C17.9329 25.2368 18.0526 25.4464 18.2276 25.6037C18.4027 25.761 18.6239 25.8577 18.8582 25.8793C19.0926 25.9009 19.3277 25.8463 19.5286 25.7237C19.7295 25.6011 19.8855 25.4169 19.9733 25.1985L22.6158 18.5938H24.7917C25.0817 18.5938 25.3599 18.4785 25.5651 18.2734C25.7702 18.0683 25.8854 17.7901 25.8854 17.5C25.8854 17.2099 25.7702 16.9317 25.5651 16.7266C25.3599 16.5215 25.0817 16.4062 24.7917 16.4062H21.875C21.6566 16.4063 21.4432 16.4718 21.2623 16.5942C21.0814 16.7166 20.9413 16.8904 20.86 17.0931L19.3083 20.9708L17.1135 9.99396Z" />
        </svg>
    </a>
    <!-- Label - Shows when sidebar is expanded or on hover when collapsed -->
    <a href="{{ route('activity.index') }}" x-show="sidebarExpanded"
        class="ml-1 pr-2 text-gray-700 text-sm font-medium {{ $active === 'activity' ? 'text-white' : '' }}"
        :class="{ 'group-hover:text-white': sidebarExpanded }">
        Activity
    </a>

    <!-- Tooltip - Shows only on hover when sidebar is collapsed -->
    <div style="z-index: 999;" x-show="!sidebarExpanded"
        class="hidden group-hover:block text-sm text-white text-center w-32 py-[2px] rounded-md absolute bg-sky-blue left-24">
        Activity
    </div>
</div>
