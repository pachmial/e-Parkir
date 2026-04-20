<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white w-[320px] h-[700px] rounded-3xl p-5 flex flex-col">

        <!-- 🔝 TITLE -->
        <h1 class="text-center text-xl font-bold mt-10 mb-10">Register</h1>

        <!-- 🔄 TOGGLE LOGIN / DAFTAR -->
        <div class="flex bg-white rounded-xl border border-gray-300  mb-10">

         <!-- LOGIN ( non aktif) -->
        <button class="flex-1 py-2 rounded-xl text-black text-sm font-medium">
                Login
        </button>
        <!-- DAFTAR (aktif) -->
        <button class="flex-1 py-2 rounded-xl text-white text-sm font-medium
            bg-gradient-to-r from-[#0F1226] to-purple-600">
            Daftar
        </button>

        </div>

        <!-- 📄 FORM -->
        <div class="flex flex-col gap-2">

            <!-- email -->
            <input 
                type="text" 
                placeholder="Nama Lengkap"
                class="bg-gray-100 px-3 py-3 rounded-xl outline-none"
            >

            <!-- password -->
            <input 
                type="email" 
                placeholder="Masukkan Email"
                class="bg-gray-100 px-3 py-3 rounded-xl outline-none"
            >
            <!-- password -->
            <input 
                type="password" 
                placeholder="Masukkan password"
                class="bg-gray-100 px-3 py-3 rounded-xl outline-none"
            >
            <!-- password -->
            <input 
                type="password" 
                placeholder="Ulang password"
                class="bg-gray-100 px-3 py-3 rounded-xl outline-none"
            >

            <!-- lupa password -->
            <p class="text-sm text-gray-500">
                Lupa password?
            </p>

        </div>

        <!-- 🔘 BUTTON LOGIN -->
        <button class="mt-6 py-3 rounded-xl text-white font-semibold 
            bg-gradient-to-r from-purple-500 to-[#1C1F4A] shadow-lg">
            Login
        </button>

        <!-- 🔽 REGISTER -->
        <div class="mt-10">
        <p class="text-sm text-center mt-auto text-gray-600">
            Sudah punya akun? 
            <span class="font-semibold text-black">Login sekarang</span>
        </p>
        </div>

    </div>

</body>
</html>