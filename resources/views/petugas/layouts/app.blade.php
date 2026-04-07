<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Perpus</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <div class="w-64 bg-blue-600 text-white fixed h-full">
        @include('petugas.layouts.sidebar')
    </div>

    {{-- CONTENT --}}
    <div class="ml-64 flex-1 p-6">
        @yield('content')
    </div>

</div>

@stack('scripts')

</body>
</html>
