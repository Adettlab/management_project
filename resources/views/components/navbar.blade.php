<nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
    <div class="flex items-center">
        <!-- Logo -->
        <h2 class="text-2xl font-semibold">Helper</h2>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Profile Section -->
        <div class="flex items-center space-x-3">
            <span class="font-semibold">{{ Auth::user()->name }}</span>
            <!-- Profile Avatar as Dropdown Trigger -->
            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center cursor-pointer"
                id="profileDropdown">
                <!-- User Icon -->
                <i class="fas fa-user text-gray-500"></i>
            </div>

            <!-- Dropdown Menu -->
            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10">
                <div class="py-2 px-4 text-gray-800 border-b">
                    <!-- Display the User's Name from Database -->
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                </div>
                <!-- Dropdown Items -->
                <div class="py-2">
                    <!-- Profile Option (Optional) -->
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <!-- Logout Option -->
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Dropdown toggle logic
    const profileDropdown = document.getElementById('profileDropdown');
    const dropdownMenu = document.getElementById('dropdownMenu');

    profileDropdown.addEventListener('click', function() {
        dropdownMenu.classList.toggle('hidden');
    });

    // Close the dropdown when clicking outside of it
    window.addEventListener('click', function(e) {
        if (!profileDropdown.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
