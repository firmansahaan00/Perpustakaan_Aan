<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar E-Perpus</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex">

    <!-- SIDEBAR -->
    <div class="text-white p-4 w-[250px] min-h-screen bg-blue-600">

        <!-- Logo -->
        <div class="flex items-center mb-6">
            <img src="public/stack-of-books.png" class="w-10 mr-2">
            <h5 class="text-lg font-semibold">E-Perpus</h5>
        </div>

        <!-- Dashboard -->
        <a href="{{ route('kepala.dashboard')}}" data-menu="dashboard"
        class="menu-item flex items-center mb-3 px-3 py-2 rounded-xl transition-all duration-300
        hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
            <img src="images/icons/dashboard.png" class="w-5 mr-2">
            Dashboard
        </a>

        <!-- Transaksi -->
        <div class="mb-3">
            <button onclick="toggleMenu()" data-menu="transaksi"
            class="menu-item w-full flex items-center px-3 py-2 rounded-xl transition-all duration-300
            hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
                <img src="images/icons/transaksi.png" class="w-5 mr-2">
                Transaksi
            </button>

            <div id="submenu" class="hidden mt-2 ml-6">
                <a href="#" data-menu="peminjaman"
                class="submenu-item block mb-1 px-2 py-1 rounded hover:bg-white/20 transition">
                    Peminjaman
                </a>

                <a href="#" data-menu="pengembalian"
                class="submenu-item block px-2 py-1 rounded hover:bg-white/20 transition">
                    Pengembalian
                </a>
            </div>
        </div>

        <!-- Daftar Buku -->
        <a href="{{ route ('kepala.buku.index')}}" data-menu="buku"
        class="menu-item flex items-center mb-3 px-3 py-2 rounded-xl transition-all duration-300
        hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
            <img src="images/icons/buku.png" class="w-5 mr-2">
            Daftar Buku
        </a>

        <!-- Daftar Pengguna -->
        <a href="{{ route ('kepala.akun.index')}}" data-menu="pengguna"
        class="menu-item flex items-center mb-3 px-3 py-2 rounded-xl transition-all duration-300
        hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
            <img src="images/icons/pengguna.png" class="w-5 mr-2">
            Daftar Pengguna
        </a>

        <!-- Profile -->
        <a href="#" data-menu="profile"
        class="menu-item flex items-center px-3 py-2 rounded-xl transition-all duration-300
        hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
            <img src="images/icons/profile.png" class="w-5 mr-2">
            Profile
        </a>

    </div>

    <!-- SCRIPT -->
    <script>
    const menuItems = document.querySelectorAll('.menu-item, .submenu-item');

    // load active
    const activeMenu = localStorage.getItem('activeMenu');

    if (activeMenu) {
        const el = document.querySelector(`[data-menu="${activeMenu}"]`);
        if (el) {
            el.classList.add('bg-blue-500','shadow-xl','-translate-y-1','scale-[1.03]');

            if (el.classList.contains('submenu-item')) {
                document.getElementById('submenu').classList.remove('hidden');
                el.classList.add('bg-white/20');
            }
        }
    }

    // klik menu
    menuItems.forEach(item => {
        item.addEventListener('click', function() {

            // reset
            document.querySelectorAll('.menu-item').forEach(i => {
                i.classList.remove('bg-blue-500','shadow-xl','-translate-y-1','scale-[1.03]');
            });

            document.querySelectorAll('.submenu-item').forEach(i => {
                i.classList.remove('bg-white/20');
            });

            // set aktif
            if (this.classList.contains('submenu-item')) {
                this.classList.add('bg-white/20');
                document.getElementById('submenu').classList.remove('hidden');
            } else {
                this.classList.add('bg-blue-500','shadow-xl','-translate-y-1','scale-[1.03]');
            }

            // simpan
            localStorage.setItem('activeMenu', this.dataset.menu);
        });
    });

    // toggle submenu
    function toggleMenu() {
        document.getElementById('submenu').classList.toggle('hidden');
    }
    </script>

</body>
</html>
