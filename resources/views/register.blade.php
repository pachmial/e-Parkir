<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white w-[320px] h-[700px] rounded-3xl p-5 flex flex-col shadow-2xl overflow-hidden">

        <h1 class="text-center text-xl font-bold mt-10 mb-10">Register</h1>

        <div class="flex bg-white rounded-xl border border-gray-300 mb-10 overflow-hidden">
            <a href="{{ url('/login') }}" class="flex-1 py-2 text-center text-black text-sm font-medium hover:bg-gray-50">
                Login
            </a>
            <div class="flex-1 py-2 text-center text-white text-sm font-medium bg-gradient-to-r from-[#0F1226] to-purple-600">
                Daftar
            </div>
        </div>

        <form action="{{ route('register.submit') }}" method="POST" class="flex flex-col gap-2">
            @csrf <input 
                type="text" 
                name="nama" 
                placeholder="Nama Lengkap"
                class="bg-gray-100 px-3 py-3 rounded-xl outline-none"
                required
            >

            <input 
                type="email" 
                name="email" 
                placeholder="Masukkan Email"
                class="bg-gray-100 px-3 py-3 rounded-xl outline-none"
                required
            >

            <input 
                type="password" 
                name="password" 
                placeholder="Masukkan password"
                class="bg-gray-100 px-3 py-3 rounded-xl outline-none"
                required
            >

            <input 
                type="password" 
                name="kata_sandi_confirmation" 
                placeholder="Ulang password"
                class="bg-gray-100 px-3 py-3 rounded-xl outline-none"
                required
            >

            <button type="submit" class="mt-6 py-3 rounded-xl text-white font-semibold 
                bg-gradient-to-r from-purple-500 to-[#1C1F4A] shadow-lg hover:opacity-90">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-auto mb-4">
            <p class="text-xs text-center text-gray-600">
                Sudah punya akun? 
                <a href="{{ url('/login') }}" class="font-semibold text-black">Login sekarang</a>
            </p>
        </div>

    </div>

</body>
</html>