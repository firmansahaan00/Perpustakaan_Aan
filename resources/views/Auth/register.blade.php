<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-screen">

<div class="flex h-full">

    <!-- LEFT (FORM) -->
    <div class="w-1/2 flex items-center justify-center bg-white px-16">
        <div class="w-full max-w-md">

            <h2 class="text-3xl font-bold mb-2">Buat Akun Anda</h2>
            <p class="text-gray-500 mb-6">Daftar untuk menggunakan sistem perpustakaan </p>

            {{-- ERROR --}}
            @if($errors->any())
                <div class="bg-red-100 text-red-600 p-2 mb-4 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/register" class="space-y-4">
                @csrf

                <input type="text" name="name" placeholder="Nama"
                    class="w-full p-3 border rounded-full pr-12 focus:ring-2 focus:ring-blue-500 outline-none">

                <input type="email" name="email" placeholder="Email"
                    class="w-full p-3 border rounded-full pr-12 focus:ring-2 focus:ring-blue-500 outline-none">

                <input type="password" name="password" placeholder="Password"
                    class="w-full p-3 border rounded-full pr-12 focus:ring-2 focus:ring-blue-500 outline-none">

                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                    class="w-full p-3 border rounded-full pr-12 focus:ring-2 focus:ring-blue-500 outline-none">

                <input type="text" name="nis" placeholder="NIS"
                    class="w-full p-3 border rounded-full pr-12 focus:ring-2 focus:ring-blue-500 outline-none">

                <input type="text" name="kelas" placeholder="Kelas"
                    class="w-full p-3 border rounded-full pr-12 focus:ring-2 focus:ring-blue-500 outline-none">

                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg transition">
                    Buat
                </button>
            </form>

        </div>
    </div>

    <!-- RIGHT (WELCOME PANEL FULL HEIGHT) -->
    <div class="w-1/2 bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex flex-col justify-center items-center px-20 rounded-l-[90px]">
        <h2 class="text-4xl font-bold mb-4">Selamat Datang</h2>
        <p class="text-center text-lg mb-8 max-w-md">
            Sudah punya akun? Login untuk mengakses sistem perpustakaan digital.
        </p>

        <a href="/login"
           class="border-2 border-white px-8 py-3 rounded-full text-lg hover:bg-white hover:text-blue-600 transition">
            Masuk
        </a>
    </div>

</div>

</body>
</html>
