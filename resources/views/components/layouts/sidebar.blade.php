<div class="sm:w-[13%] sm:h-screen xs:w-screen xs:h-[9vh] xs:bottom-0 sm:bottom-auto fixed z-10">
    <nav
        class="sm:shadow-none xs:shadow-[0px_0px_3px_5px_rgba(0,0,0,0.03)] sm:pt-8 xs:pt-2 xs:pb-4 sm:pb-0 sm:px-4 sm:w-full xs:items-start bg-white flex sm:flex-col xs:flex-row sm:space-y-7 xs:space-x-6 sm:space-x-0 sm:justify-normal xs:justify-center h-full border-r relative z-50">
        {{-- dashboard --}}
        <x-sidebar.dashboard :active="$active" />

        {{-- Projects - cek permission hybrid --}}
        @if (auth()->user()->hasPermission('projects', 'view'))
            <x-sidebar.project :active="$active" />
        @endif

        {{-- Tasks - cek permission hybrid + fallback employee --}}
        @php
            $canViewTasks = false;

            // Cek custom permission dulu
            if (auth()->user()->hasCustomPermissions()) {
                $canViewTasks = auth()->user()->hasPermission('tasks', 'view');
            } else {
                // Fallback ke logic lama: hanya employee yang bisa lihat tasks
                $canViewTasks = auth()->user()->employee ? true : false;
            }
        @endphp

        @if ($canViewTasks)
            <x-sidebar.tasks :active="$active" />
        @endif

        {{-- Activity - selalu tampil --}}
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
