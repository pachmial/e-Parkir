<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">

    <div class="
        bg-white 
        w-[360px] h-[640px] rounded-3xl p-5 
        md:w-screen md:h-screen md:rounded-none md:flex md:items-center md:justify-center
    ">

        <!-- container isi -->
        <div class="w-full max-w-sm mx-auto">

            <!-- 🔝 TITLE -->
            <h1 class="text-center text-xl md:text-3xl font-bold mt-10 md:mt-0 mb-10">
                Login
            </h1>

            <!-- 🔄 TOGGLE -->
            <div class="flex bg-white rounded-xl border border-gray-300 mb-10">

                <button class="flex-1 py-2 rounded-xl text-white text-sm font-medium
                    bg-gradient-to-r from-[#0F1226] to-purple-600">
                    Login
                </button>

                <button class="flex-1 py-2 rounded-xl text-black text-sm font-medium">
                    Daftar
                </button>

            </div>

            <!-- 📄 FORM -->
            <div class="flex flex-col gap-4">

                <input 
                    type="email" 
                    placeholder="Masukkan Email"
                    class="bg-gray-100 px-4 py-3 rounded-xl outline-none"
                >

                <input 
                    type="password" 
                    placeholder="Masukkan password"
                    class="bg-gray-100 px-4 py-3 rounded-xl outline-none"
                >

                <p class="text-sm text-gray-500">
                    Lupa password?
                </p>

            </div>

            <!-- 🔘 BUTTON -->
            <button class="mt-6 w-full py-3 rounded-xl text-white font-semibold 
                bg-gradient-to-r from-purple-500 to-[#1C1F4A] shadow-lg">
                Login
            </button>

            <!-- 🔽 REGISTER -->
            <p class="text-sm text-center mt-10 text-gray-600">
                Belum punya akun? 
                <span class="font-semibold text-black">Daftar sekarang</span>
            </p>

        </div>

    </div>

</body>
</html>