<div class="w-64 bg-white h-screen shadow-lg">
    <nav class="mt-10">
        <ul id="nav-menu">
            <li class="px-6 py-3">
                <a href="#" class="flex items-center text-blue-500 hover:text-blue-500 font-semibold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m4 0a2 2 0 01-2 2H5a2 2 0 01-2-2m0 0a2 2 0 012-2h2">
                        </path>
                    </svg>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li class="px-6 py-3">
                <a href="#" class="flex items-center text-grey-500 hover:text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18m-6 5h6"></path>
                    </svg>
                    <span class="ml-3">Projects</span>
                </a>
            </li>
            <li class="px-6 py-3">
                <a href="#" class="flex items-center text-grey-500 hover:text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m2 0a2 2 0 002-2m0 0a2 2 0 00-2-2m-6 4V6a2 2 0 00-2-2m0 8a2 2 0 00-2-2m6 0V6m0 12h-6m0-12v4m0 8h6m6 0a2 2 0 002-2m0 0a2 2 0 00-2-2m-6 0v-4">
                        </path>
                    </svg>
                    <span class="ml-3">Tickets</span>
                </a>
            </li>
        </ul>
    </nav>

    <script>
        // Retrieve all links in the menu
        const menuLinks = document.querySelectorAll('#nav-menu a');

        // Add event listeners for each link
        menuLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // stop default link
                e.preventDefault();

                // Remove the font-bold class from all links
                menuLinks.forEach(link => link.classList.remove('font-semibold', 'font-bold',
                    'text-blue-500'));

                // Add font-bold and text-blue-500 classes to the clicked link
                this.classList.add('font-bold', 'text-blue-500');
            });
        });
    </script>
</div>
