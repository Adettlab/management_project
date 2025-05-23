<div id="sidebar" class="h-screen fixed transition-all duration-300 collapsed bg-white border-r z-50">
    <!-- Toggle Button -->
    <button id="sidebarToggle"
        class="absolute -right-3 top-1 bg-sky-blue text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-[#6FAEC9] transition-colors z-60">
        <svg class="w-3 h-3 transition-transform duration-300" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </button>

    <nav class="pt-8 items-start bg-white flex flex-col space-y-4 h-full px-4">

        {{-- dashboard --}}
        <x-sidebar.dashboard :active="$active" />

        {{-- project --}}
        <x-sidebar.project :active="$active" />

        {{-- tasks --}}
        @if (auth()->user()->employee)
            <x-sidebar.tasks :active="$active" />
        @endif

        {{-- activity --}}
        <x-sidebar.activity :active="$active" />

        {{-- Administration --}}
        <x-sidebar.administration :active="$active" />

        {{-- admin --}}
        @if (!auth()->user()->employee)
            <x-sidebar.admin :active="$active" />
        @endif
    </nav>
</div>

{{-- <div class="w-[8.5%] h-screen fixed">
    <nav class="pt-8 items-center bg-white flex flex-col space-y-7 h-full relative border-r relative z-50"> --}}
