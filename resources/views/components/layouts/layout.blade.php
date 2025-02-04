<x-layout-app :title="$title">
    {{-- @vite('resources/css/app.css') --}}
    <div class="flex flex-col">
        <!-- Navbar -->
        <x-layouts.navbar :title="$title" :active="$active ?? ''"/>

        <div class="flex flex-1">
            <!-- Sidebar -->
            <x-layouts.sidebar :active="$active ?? ''" />

            <!-- Main Content -->
            <main class="flex-1 px-6 py-4 ml-[8%]">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-layout-app>
