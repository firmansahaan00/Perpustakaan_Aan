<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Perpus</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- ALPINE JS --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- FEATHER ICON --}}
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <div class="w-64 bg-blue-600 text-white fixed h-full">
        @include('anggota.layouts.sidebar')
    </div>

    
    <div class="ml-64 flex-1 p-6">
        @yield('content')
    </div>

</div>


@stack('scripts')

// Inti Feather Icon
<script>
    document.addEventListener('DOMContentLoaded', function () {
        feather.replace();
    });
</script>

</body>
</html>