<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <!-- Vite CSS -->
    @vite('resources/css/app.css')
</head>

<body class="bg-primary-white">

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

    {{-- Vite JS --}}
    @vite('resources/js/app.js')
</body>

</html>
