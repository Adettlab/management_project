<div class="sm:w-[8.5%] sm:h-screen xs:w-screen xs:h-[9vh] xs:bottom-0 sm:bottom-auto fixed z-10">
    <nav
        class="sm:shadow-none xs:shadow-[0px_0px_3px_5px_rgba(0,0,0,0.03)] sm:pt-8 xs:pt-2 xs:pb-4 sm:pb-0 sm:items-center xs:items-start bg-white flex sm:flex-col xs:flex-row sm:space-y-7 xs:space-x-6 sm:space-x-0 sm:justify-normal xs:justify-center h-full border-r relative z-50">
        {{-- dashboard --}}
        <x-sidebar.dashboard :active="$active" />

        {{-- project --}}
        <x-sidebar.project :active="$active" />

        {{-- tasks --}}
        <x-sidebar.tasks :active="$active" />

        {{-- activity --}}
        <x-sidebar.activity :active="$active" />

        {{-- Administration --}}
        <x-sidebar.administration :active="$active" />

        {{-- admin --}}
        <div class="sm:block xs:hidden">
            @if (!auth()->user()->employee)
                <x-sidebar.admin :active="$active" />
            @endif
        </div>
    </nav>
</div>
