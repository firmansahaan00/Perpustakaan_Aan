<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Anggota</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="flex">

    <!-- SIDEBAR -->
    <div class="text-white p-4 w-[250px] min-h-screen bg-blue-600 flex flex-col justify-between">

        <!-- ATAS -->
        <div>

            <!-- Logo -->
            <div class="flex items-center mb-6 gap-2">
                <i data-feather="book-open" class="w-8 h-8"></i>
                <h5 class="text-lg font-semibold">E-Perpus</h5>
            </div>

            <!-- Dashboard -->
            <a href="{{ route('anggota.dashboard') }}" data-menu="dashboard"
            class="menu-item flex items-center gap-2 mb-3 px-3 py-2 rounded-xl transition-all duration-300
            hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
                <i data-feather="home" class="w-5"></i>
                Dashboard
            </a>

            <!-- Riwayat -->
            <a href="#" data-menu="riwayat"
            class="menu-item flex items-center gap-2 mb-3 px-3 py-2 rounded-xl transition-all duration-300
            hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
                <i data-feather="clock" class="w-5"></i>
                Riwayat Peminjaman
            </a>

            <!-- Daftar Buku -->
            <a href="{{ route ('anggota.buku.index')}}" data-menu="buku"
            class="menu-item flex items-center gap-2 mb-3 px-3 py-2 rounded-xl transition-all duration-300
            hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
                <i data-feather="book" class="w-5"></i>
                Daftar Buku
            </a>

            <!-- Profile -->
            <a href="#" data-menu="profile"
            class="menu-item flex items-center gap-2 px-3 py-2 rounded-xl transition-all duration-300
            hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
                <i data-feather="user" class="w-5"></i>
                Profile
            </a>

        </div>

        <!-- LOGOUT -->
        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 bg-red-600 rounded-xl hover:bg-red-700 transition">
                <i data-feather="log-out" class="w-5"></i>
                Logout
            </button>
        </form>

    </div>

    <!-- SCRIPT ACTIVE MENU -->
    <script>
    const menuItems = document.querySelectorAll('.menu-item');

    const activeMenu = localStorage.getItem('activeMenu');

    if (activeMenu) {
        const el = document.querySelector(`[data-menu="${activeMenu}"]`);
        if (el) {
            el.classList.add('bg-blue-500','shadow-xl','-translate-y-1','scale-[1.03]');
        }
    }

    menuItems.forEach(item => {
        item.addEventListener('click', function() {

            document.querySelectorAll('.menu-item').forEach(i => {
                i.classList.remove('bg-blue-500','shadow-xl','-translate-y-1','scale-[1.03]');
            });

            this.classList.add('bg-blue-500','shadow-xl','-translate-y-1','scale-[1.03]');

            localStorage.setItem('activeMenu', this.dataset.menu);
        });
    });
    </script>

    <!-- FEATHER ICON -->
    <script>
        feather.replace();
    </script>

</body>
</html>