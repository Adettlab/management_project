<x-layout-app :title="$title">
    <div class="flex flex-col">
        <!-- Navbar -->
        <x-layouts.navbar :title="$title" :active="$active ?? ''" />

        <div class="flex flex-1">
            <!-- Sidebar -->
            <x-layouts.sidebar :active="$active ?? ''" />

            <!-- Main Content -->
            <main class="flex-1 ml-[14%]">
                <div class="px-6 py-4">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</x-layout-app>
