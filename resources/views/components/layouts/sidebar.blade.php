<div class=" fixed h-screen w-[14%]">
    <nav class="pt-8 items-center bg-white flex flex-col h-full relative border-r z-50">
        <div class="flex flex-col w-full justify-start px-2"">
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
