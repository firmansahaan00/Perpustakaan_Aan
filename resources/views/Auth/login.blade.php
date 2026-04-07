<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="h-screen w-screen flex">

    <!-- LEFT -->
    <div class="w-1/2 h-full bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex flex-col justify-center items-center px-20 rounded-r-[120px]">
        <h2 class="text-5xl font-bold mb-4">Selamat Datang!</h2>
        <p class="text-center text-lg mb-8 max-w-md">
            Belum Punya Akun? Daftar Sekarang Untuk Mulai Menggunakan Sistem Perpustakaan Digital.
        </p>

        <a href="/register"
           class="border-2 border-white px-8 py-3 rounded-full text-lg hover:bg-white hover:text-blue-600 transition">
            Daftar
        </a>
    </div>

    <!-- RIGHT -->
    <div class="w-1/2 h-full flex items-center justify-center bg-white px-20">
        <div class="w-full max-w-md">

            <h2 class="text-4xl font-bold mb-2">Masuk Akun Anda</h2>
            <p class="text-gray-500 mb-6">Masuk ke akun untuk mengakses perpustakaan digital.</p>

            @if(session('error'))
                <div class="bg-red-100 text-red-600 p-2 mb-4 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-4">
                @csrf

                <input type="email" name="email" placeholder="Email"
                    class="w-full p-3 border rounded-full focus:ring-2 focus:ring-blue-500 outline-none" required>

                <!-- PASSWORD -->
                <div class="relative">
                    <input id="password" type="password" name="password"
                        class="w-full p-3 border rounded-full pr-12 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Password" required>

                    <button type="button"
                        onclick="togglePassword('password', this)"
                        class="absolute right-4 top-3 text-gray-500">
                        <i data-feather="eye"></i>
                    </button>
                </div>

                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full transition">
                    Masuk
                </button>
            </form>

        </div>
    </div>

<script>
feather.replace();

function togglePassword(id, el) {
    const input = document.getElementById(id);
    const icon = el.querySelector("i");

    if (input.type === "password") {
        input.type = "text";
        icon.setAttribute("data-feather", "eye-off");
    } else {
        input.type = "password";
        icon.setAttribute("data-feather", "eye");
    }

    feather.replace();
}
</script>

</body>
</html>