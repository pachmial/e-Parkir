<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">

    <div class="
        bg-white 
        w-[360px] h-[640px] rounded-3xl p-5 
        md:w-screen md:h-screen md:rounded-none md:flex md:items-center md:justify-center
    ">

        <div class="w-full max-w-sm mx-auto">

            <h1 class="text-center text-xl md:text-3xl font-bold mt-10 md:mt-0 mb-10">
                Register
            </h1>

            <!-- SWITCH LOGIN / REGISTER -->
            <div class="flex bg-white rounded-xl border border-gray-300 mb-10 overflow-hidden">
                <a href="{{ url('/login') }}" 
                   class="flex-1 py-2 text-center text-black text-sm font-medium hover:bg-gray-100">
                    Login
                </a>
                <div class="flex-1 py-2 text-center text-white text-sm font-medium bg-gradient-to-r from-[#0F1226] to-purple-600">
                    Daftar
                </div>
            </div>

            <!-- FORM -->
            <form action="{{ route('register.submit') }}" method="POST">
                @csrf

                <div class="flex flex-col gap-4">
                    <input 
                        type="text" 
                        name="nama" 
                        placeholder="Nama Lengkap"
                        class="bg-gray-100 px-4 py-3 rounded-xl outline-none"
                        required
                    >

                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Masukkan Email"
                        class="bg-gray-100 px-4 py-3 rounded-xl outline-none"
                        required
                    >

                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Masukkan password"
                        class="bg-gray-100 px-4 py-3 rounded-xl outline-none"
                        required
                    >

                    <input 
                        type="password" 
                        name="password_confirmation" 
                        placeholder="Ulang password"
                        class="bg-gray-100 px-4 py-3 rounded-xl outline-none"
                        required
                    >

                    @if($errors->any())
                        <p class="text-xs text-red-500">{{ $errors->first() }}</p>
                    @endif
                </div>

                <button type="submit" 
                    class="mt-6 w-full py-3 rounded-xl text-white font-semibold 
                    bg-gradient-to-r from-purple-500 to-[#1C1F4A] shadow-lg hover:opacity-90">
                    Daftar Sekarang
                </button>
            </form>

            <!-- FOOTER -->
            <p class="text-sm text-center mt-10 text-gray-600">
                Sudah punya akun? 
                <a href="{{ url('/login') }}" class="font-semibold text-black">
                    Login sekarang
                </a>
            </p>

        </div>

    </div>

</body>
</html>