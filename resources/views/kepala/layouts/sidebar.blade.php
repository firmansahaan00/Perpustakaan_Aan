<div class="text-white p-4 w-[250px] min-h-screen bg-blue-600 flex flex-col justify-between">

    <!-- Bagian atas sidebar -->
    <div>
        <!-- Logo -->
        <div class="flex items-center mb-6 gap-2">
            <i data-feather="book-open" class="w-8 h-8"></i>
            <h5 class="text-lg font-semibold">E-Perpus</h5>
        </div>

        <!-- Dashboard -->
        <a href="{{ route('kepala.dashboard')}}" data-menu="dashboard"
        class="menu-item flex items-center gap-2 mb-3 px-3 py-2 rounded-xl transition-all duration-300
        hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
            <i data-feather="home" class="w-5"></i>
            Dashboard
        </a>

        <!-- Transaksi -->
        <div class="mb-3">
            <button onclick="toggleMenu()" data-menu="transaksi"
            class="menu-item w-full flex items-center gap-2 px-3 py-2 rounded-xl transition-all duration-300
            hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
                <i data-feather="repeat" class="w-5"></i>
                Transaksi
            </button>

            <div id="submenu" class="hidden mt-2 ml-6">
                <a href="#" data-menu="peminjaman"
                class="submenu-item flex items-center gap-2 mb-1 px-2 py-1 rounded hover:bg-white/20 transition">
                    <i data-feather="arrow-down-circle" class="w-4"></i>
                    Peminjaman
                </a>

                <a href="#" data-menu="pengembalian"
                class="submenu-item flex items-center gap-2 px-2 py-1 rounded hover:bg-white/20 transition">
                    <i data-feather="arrow-up-circle" class="w-4"></i>
                    Pengembalian
                </a>
            </div>
        </div>

        <!-- Daftar Buku -->
        <a href="{{ route ('kepala.buku.index')}}" data-menu="buku"
        class="menu-item flex items-center gap-2 mb-3 px-3 py-2 rounded-xl transition-all duration-300
        hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
            <i data-feather="book" class="w-5"></i>
            Daftar Buku
        </a>

        <!-- Daftar Pengguna -->
        <a href="{{ route ('kepala.akun.index')}}" data-menu="pengguna"
        class="menu-item flex items-center gap-2 mb-3 px-3 py-2 rounded-xl transition-all duration-300
        hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
            <i data-feather="users" class="w-5"></i>
            Daftar Pengguna
        </a>

        <!-- Profile -->
        <a href="{{ route ('kepala.profile.index')}}" data-menu="profile"
        class="menu-item flex items-center gap-2 px-3 py-2 rounded-xl transition-all duration-300
        hover:bg-gradient-to-r hover:from-gray-900 hover:to-blue-500 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.03]">
            <i data-feather="user" class="w-5"></i>
            Profile
        </a>
    </div>

    <!-- Logout di bawah -->
    <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 bg-red-600 rounded-xl hover:bg-red-700 transition">
            <i data-feather="log-out" class="w-5"></i>
            Logout
        </button>
    </form>

</div>
