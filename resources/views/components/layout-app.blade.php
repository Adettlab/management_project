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
