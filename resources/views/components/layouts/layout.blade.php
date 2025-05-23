<x-layout-app :title="$title">
    <div class="flex flex-col">
        <!-- Navbar -->
        <x-layouts.navbar :title="$title" :active="$active ?? ''" />
        <div class="flex flex-1">
            <!-- Sidebar -->
            <x-layouts.sidebar :active="$active ?? ''" />
            <!-- Main Content -->
            <main id="mainContent" class="flex-1 px-6 py-4 transition-all duration-300 sidebar-collapsed">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-layout-app>
