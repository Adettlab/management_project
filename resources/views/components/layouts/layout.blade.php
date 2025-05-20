<x-layout-app :title="$title">
    {{-- @vite('resources/css/app.css') --}}
    <div class="flex flex-col">
        <!-- Navbar -->
        <x-layouts.navbar :title="$title" :active="$active ?? ''"/>

        <div class="flex flex-1">
            <!-- Sidebar -->
            <x-layouts.sidebar :active="$active ?? ''" />

            <!-- Main Content -->
            <main class="flex-1 transition-all duration-300"
                :class="{ 'ml-[8.5%]': !sidebarExpanded, 'ml-[14%]': sidebarExpanded }" x-init="document.querySelector('main').classList.add(sidebarExpanded ? 'content-init-expanded' : 'content-init-collapsed')">
                <div class="px-6 py-4">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</x-layout-app>
