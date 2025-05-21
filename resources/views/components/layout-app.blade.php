<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Vite CSS -->
    @vite('resources/css/app.css')

    <!-- Prevent FOUC (Flash of Unstyled Content) -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Pre-load state to prevent layout shift */
        .sidebar-init-expanded {
            width: 14%;
        }

        .sidebar-init-collapsed {
            width: 8.5%;
        }

        .content-init-expanded {
            margin-left: 14%;
        }

        .content-init-collapsed {
            margin-left: 8.5%;
        }
    </style>
</head>

<body x-data="sidebarState()" x-init="initSidebar()" class="bg-primary-white" x-cloak>

    {{ $slot }}

    {{-- Flash message untuk SweetAlert --}}
    @if (session('success'))
        <script>
            window.flashMessage = {
                type: 'success',
                title: 'Success!',
                message: "{{ session('success') }}"
            };
        </script>
    @endif

    @if (session('error'))
        <script>
            window.flashMessage = {
                type: 'error',
                title: 'Error!',
                message: "{{ session('error') }}"
            };
        </script>
    @endif

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Custom Alpine.js initialization -->
    <script>
        function sidebarState() {
            return {
                sidebarExpanded: localStorage.getItem('sidebarExpanded') === 'false' ? false : true,

                toggleSidebar() {
                    this.sidebarExpanded = !this.sidebarExpanded;
                    localStorage.setItem('sidebarExpanded', this.sidebarExpanded);
                },

                initSidebar() {
                    // Ensure Alpine has loaded before manipulating classes
                    this.$nextTick(() => {
                        document.documentElement.classList.add(
                            this.sidebarExpanded ? 'sidebar-expanded' : 'sidebar-collapsed'
                        );
                    });
                }
            }
        }
    </script>

    {{-- Vite JS --}}
    @vite('resources/js/app.js')
</body>

</html>
