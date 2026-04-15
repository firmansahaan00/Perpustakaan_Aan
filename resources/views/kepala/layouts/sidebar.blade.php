<div class="text-white w-[250px] min-h-screen bg-blue-600 flex flex-col justify-between">

    <!-- TOP -->
    <div class="p-4">

        <!-- LOGO -->
        <div class="flex items-center mb-6 gap-2">
            <i data-feather="book" class="w-8 h-8"></i>
            <h5 class="text-lg font-semibold">E-Perpus</h5>
        </div>

        <!-- DASHBOARD -->
        <a href="{{ route('kepala.dashboard') }}"
           data-menu="dashboard"
           class="menu-item flex items-center gap-2 mb-2 px-3 py-2 rounded-xl transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
            <i data-feather="home" class="w-5"></i>
            Dashboard
        </a>

        <!-- LAPORAN -->
        <div class="mb-2">

            <a href="{{ route('kepala.laporan.index') }}"
               class="menu-item flex items-center justify-between gap-2 px-3 py-2 rounded-xl transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">

                <div class="flex items-center gap-2">
                    <i data-feather="bar-chart-2" class="w-5"></i>
                    Laporan
                </div>

               
            </a>

            <!-- SUBMENU -->
            <div id="submenu" class="mt-2 ml-8 space-y-2 hidden">

                <a href="#"
                   class="submenu-item flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-blue-500/50 transition">
                    <i data-feather="download" class="w-4"></i>
                    Peminjaman
                </a>

                <a href="#"
                   class="submenu-item flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-blue-500/50 transition">
                    <i data-feather="upload" class="w-4"></i>
                    Pengembalian
                </a>

                <a href="#"
                   class="submenu-item flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-blue-500/50 transition">
                    <i data-feather="x-circle" class="w-4"></i>
                    Penolakan
                </a>

                <a href="#"
                   class="submenu-item flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-blue-500/50 transition">
                    <i data-feather="dollar-sign" class="w-4"></i>
                    Denda
                </a>

            </div>
        </div>

        <!-- BUKU -->
        <a href="{{ route('kepala.buku.index') }}"
           class="menu-item flex items-center gap-2 mb-2 px-3 py-2 rounded-xl transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
            <i data-feather="book-open" class="w-5"></i>
            Daftar Buku
        </a>

        <!-- PENGGUNA -->
        <a href="{{ route('kepala.akun.index') }}"
           class="menu-item flex items-center gap-2 mb-2 px-3 py-2 rounded-xl transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
            <i data-feather="users" class="w-5"></i>
            Daftar Pengguna
        </a>

        <!-- PROFILE -->
        <a href="{{ route('kepala.profile.index') }}"
           class="menu-item flex items-center gap-2 px-3 py-2 rounded-xl transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
            <i data-feather="user" class="w-5"></i>
            Profile
        </a>

    </div>

    <!-- BOTTOM -->
    <div class="p-4">

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="flex items-center gap-2 w-full px-3 py-2 bg-red-600 rounded-xl hover:bg-red-700 transition">
                <i data-feather="log-out" class="w-5"></i>
                Logout
            </button>
        </form>

    </div>

</div>