<div class="w-[8.5%] h-screen fixed">
    <nav class="pt-8 items-center bg-white flex flex-col space-y-7 h-full relative border-r relative z-50">
        {{-- dashboard --}}
        <x-sidebar.dashboard :active="$active" />

        {{-- project --}}
        <x-sidebar.project :active="$active" />

        {{-- tasks --}}
        @if (auth()->user()->employee)
            <x-sidebar.tasks :active="$active" />
        @endif

        {{-- board --}}
        {{-- <x-sidebar.board :active="$active" /> --}}

        {{-- activity --}}
        <x-sidebar.activity :active="$active" />

        {{-- time management --}}
        {{-- <x-sidebar.time-management :active="$active" /> --}}

        {{-- calendar --}}
        {{-- <x-sidebar.calendar :active="$active" /> --}}

        {{-- Administration --}}
        @if (auth()->user()->employee)
            <x-sidebar.administration :active="$active" />
        @endif

        {{-- setting --}}
        {{-- <x-sidebar.setting :active="$active" /> --}}

        {{-- admin --}}
        @if (!auth()->user()->employee)
            <x-sidebar.admin :active="$active" />
        @endif
    </nav>
</div>
