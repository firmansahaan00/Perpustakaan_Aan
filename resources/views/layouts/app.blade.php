<!DOCTYPE html>
<html>
<head>
    <title>E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Content --}}
    <div class="p-4 w-100">
        @yield('content')
    </div>

</div>

<script>
function toggleMenu() {
    document.getElementById('submenu').classList.toggle('d-none');
}
</script>

</body>
</html>
