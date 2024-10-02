<x-layout>
    <div class="bg-gray-100 min-h-screen">
        <div class="flex flex-col min-h-screen">
            <!-- Navbar -->
            <x-navbar />

            <div class="flex flex-1">
                <!-- Sidebar -->
                <x-sidebar />

                <!-- Main Content -->
                <main class="flex-1 p-6 bg-gray-50 overflow-y-auto">
                    <h1 class="text-3xl font-semibold mb-6">Dashboard</h1>

                    <!-- Grid Layout -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <!-- Ticket Activities -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h2 class="text-lg font-semibold mb-4">Latest tickets activities</h2>
                            <div class="flex justify-center items-center h-32">
                                <span class="text-gray-400">No records found</span>
                            </div>
                        </div>

                        <!-- Ticket Comments -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h2 class="text-lg font-semibold mb-4">Latest tickets comments</h2>
                            <div class="flex justify-center items-center h-32">
                                <span class="text-gray-400">No records found</span>
                            </div>
                        </div>

                        <!-- Latest Projects -->
                        <div class="bg-white p-6 rounded-lg shadow-md col-span-2">
                            <h2 class="text-lg font-semibold mb-4">Latest projects</h2>
                            <div class="flex justify-center items-center h-32">
                                <span class="text-gray-400">No records found</span>
                            </div>
                        </div>

                        <!-- Latest Tickets -->
                        <div class="bg-white p-6 rounded-lg shadow-md col-span-2">
                            <h2 class="text-lg font-semibold mb-4">Latest tickets</h2>
                            <div class="flex justify-center items-center h-32">
                                <span class="text-gray-400">No records found</span>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-layout>
