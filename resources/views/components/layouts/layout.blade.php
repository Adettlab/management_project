<x-layout-app :title="$title">
    {{-- @vite('resources/css/app.css') --}}
    <div class="flex flex-col">
        <!-- Navbar -->
        <x-layouts.navbar :title="$title" :active="$active ?? ''" />

        <div class="flex flex-1">
            <!-- Sidebar -->
            <x-layouts.sidebar :active="$active ?? ''" />

            <!-- Main Content -->
            <main class="flex-1 sm:px-6 py-4 sm:ml-[13%] overflow-hidden xs:pb-[9vh] sm:pb-0">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-layout-app>
