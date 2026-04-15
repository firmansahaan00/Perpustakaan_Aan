<!-- SIDEBAR ANGGOTA -->
<div class="text-white p-4 w-[250px] min-h-screen bg-blue-600 flex flex-col justify-between">

    <div>

        {{-- LOGO --}}
        <div class="flex items-center mb-6 gap-2">
            <i data-feather="book-open" class="w-8 h-8"></i>
            <h5 class="text-lg font-semibold">E-Perpus</h5>
        </div>

        {{-- DASHBOARD --}}
        <a href="{{ route('anggota.dashboard') }}"
           data-menu="dashboard"
           class="menu-item flex items-center gap-2 mb-3 px-3 py-2 rounded-xl transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
            <i data-feather="home" class="w-5"></i>
            Dashboard
        </a>

        {{-- RIWAYAT --}}
        <a href="{{ route('anggota.riwayat.index') }}"
           data-menu="riwayat"
           class="menu-item flex items-center gap-2 mb-3 px-3 py-2 rounded-xl transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
            <i data-feather="refresh-ccw" class="w-5"></i>
            Riwayat Peminjaman
        </a>

        {{-- DAFTAR BUKU --}}
        <a href="{{ route('anggota.buku.index') }}"
           data-menu="buku"
           class="menu-item flex items-center gap-2 mb-3 px-3 py-2 rounded-xl transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
            <i data-feather="book-open" class="w-5"></i>
            Daftar Buku
        </a>

        {{-- PROFILE --}}
        <a href="{{ route('anggota.profile.index') }}"
           data-menu="profile"
           class="menu-item flex items-center gap-2 px-3 py-2 rounded-xl transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
            <i data-feather="user" class="w-5"></i>
            Profile
        </a>

    </div>

    {{-- LOGOUT --}}
    <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit"
            class="flex items-center gap-2 w-full px-3 py-2 bg-red-600 rounded-xl hover:bg-red-700 transition">
            <i data-feather="log-out" class="w-5"></i>
            Logout
        </button>
    </form>

</div>

{{-- ACTIVE MENU SCRIPT --}}
<script>
const menuItems = document.querySelectorAll('.menu-item');
const activeMenu = localStorage.getItem('activeMenu');

if (activeMenu) {
    const el = document.querySelector(`[data-menu="${activeMenu}"]`);
    if (el) {
        el.classList.add('bg-blue-700', 'shadow-lg');
    }
}

menuItems.forEach(item => {
    item.addEventListener('click', function () {

        document.querySelectorAll('.menu-item').forEach(i => {
            i.classList.remove('bg-blue-700', 'shadow-lg');
        });

        this.classList.add('bg-blue-700', 'shadow-lg');

        localStorage.setItem('activeMenu', this.dataset.menu);
    });
});
</script>

{{-- FEATHER ICON --}}
<script>
    feather.replace();
</script>