<div class="sidebar-container fixed h-screen transition-all duration-300"
    :class="{ 'w-[8.5%]': !sidebarExpanded, 'w-[14%]': sidebarExpanded }" x-init="document.querySelector('.sidebar-container').classList.add(sidebarExpanded ? 'sidebar-init-expanded' : 'sidebar-init-collapsed')">
    <!-- Toggle Button -->
    <button @click="toggleSidebar()"
        class="absolute -right-3 bg-secondary-white text-[#616161] border rounded-full p-1 z-[55] hover:bg-[#6FAEC9] hover:text-white">
        <svg x-show="!sidebarExpanded" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <svg x-show="sidebarExpanded" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                clip-rule="evenodd" />
        </svg>
    </button>
    <nav class="pt-8 items-center bg-white flex flex-col h-full relative border-r z-50">
        <div class="flex flex-col space-y-7 w-full px-3"
            :class="{ '': sidebarExpanded, 'items-center': !sidebarExpanded }">
            {{-- dashboard --}}
            <x-sidebar.dashboard :active="$active" :expanded="true" />

            {{-- project --}}
            <x-sidebar.project :active="$active" :expanded="true" />

            {{-- tasks --}}
            @if (auth()->user()->employee)
                <x-sidebar.tasks :active="$active" :expanded="true" />
            @endif

            {{-- activity --}}
            <x-sidebar.activity :active="$active" :expanded="true" />

            {{-- Administration --}}
            @if (auth()->user()->employee)
                <x-sidebar.administration :active="$active" :expanded="true" />
            @endif

            {{-- admin --}}
            @if (!auth()->user()->employee)
                <x-sidebar.admin :active="$active" :expanded="true" />
            @endif
        </div>
    </nav>
</div>