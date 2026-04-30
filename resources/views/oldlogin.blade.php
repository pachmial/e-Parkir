<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Auth</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
.fade {
    transition: all 0.3s ease;
    opacity: 1;
    transform: translateX(0);
}

.hidden-form {
    opacity: 0;
    transform: translateX(20px);
    position: absolute;
    pointer-events: none;
}
</style>

</head>
<body class="bg-white flex items-center justify-center min-h-screen">

<!-- WRAPPER -->
<div class="
    bg-white 
    w-[90%] max-w-[380px]
    rounded-3xl p-5 md:p-6
    shadow-md md:shadow-xl
">

<div class="w-full max-w-sm mx-auto relative">

    <!-- TITLE -->
    <h1 id="title" class="text-center text-xl md:text-2xl font-bold mt-5 md:mt-0 mb-10">
        Login
    </h1>

    <!-- TOGGLE -->
    <div class="flex bg-white rounded-xl border border-gray-300 mb-10 overflow-hidden">

        <button id="btnLogin"
            onclick="showLogin()"
            class="flex-1 py-2 rounded-xl text-white text-sm font-medium
            bg-gradient-to-r from-[#0F1226] to-purple-600">
            Login
        </button>

        <button id="btnRegister"
            onclick="showRegister()"
            class="flex-1 py-2 rounded-xl text-black text-sm font-medium">
            Daftar
        </button>

    </div>

    <!-- FORM WRAPPER -->
    <div class="relative">

        <!-- LOGIN -->
        <div id="loginForm" class="fade flex flex-col gap-4">

            <input type="email" placeholder="Masukkan Email"
                class="bg-gray-100 px-4 py-3 rounded-xl outline-none">

            <input type="password" placeholder="Masukkan password"
                class="bg-gray-100 px-4 py-3 rounded-xl outline-none">

            <p class="text-sm text-gray-500">Lupa password?</p>

        </div>

        <!-- REGISTER -->
        <div id="registerForm" class="fade hidden-form flex flex-col gap-4">

            <input type="text" placeholder="Nama Lengkap"
                class="bg-gray-100 px-4 py-3 rounded-xl outline-none">

            <input type="email" placeholder="Masukkan Email"
                class="bg-gray-100 px-4 py-3 rounded-xl outline-none">

            <input type="password" placeholder="Masukkan password"
                class="bg-gray-100 px-4 py-3 rounded-xl outline-none">

            <input type="password" placeholder="Ulang password"
                class="bg-gray-100 px-4 py-3 rounded-xl outline-none">

        </div>

    </div>

    <!-- BUTTON -->
    <button id="submitBtn"
        class="mt-6 w-full py-3 rounded-xl text-white font-semibold 
        bg-gradient-to-r from-purple-500 to-[#1C1F4A] shadow-lg">
        Login
    </button>

    <!-- SWITCH TEXT -->
    <p id="switchText" class="text-sm text-center mt-10 text-gray-600">
        Belum punya akun? 
        <span onclick="showRegister()" class="font-semibold text-black cursor-pointer">
            Daftar sekarang
        </span>
    </p>

</div>
</div>
<script>
function showLogin(push = true) {
    document.getElementById('title').innerText = "Login";

    document.getElementById('loginForm').classList.remove('hidden-form');
    document.getElementById('registerForm').classList.add('hidden-form');

    document.getElementById('submitBtn').innerText = "Login";

    document.getElementById('btnLogin').classList.add('bg-gradient-to-r','from-[#0F1226]','to-purple-600','text-white');
    document.getElementById('btnRegister').classList.remove('bg-gradient-to-r','from-[#0F1226]','to-purple-600','text-white');

    document.getElementById('switchText').innerHTML =
        'Belum punya akun? <span onclick="showRegister()" class="font-semibold text-black cursor-pointer">Daftar sekarang</span>';

    // 🔥 update URL
    if (push) {
        history.pushState({page: "login"}, "", "/login");
    }
}

function showRegister(push = true) {
    document.getElementById('title').innerText = "Register";

    document.getElementById('registerForm').classList.remove('hidden-form');
    document.getElementById('loginForm').classList.add('hidden-form');

    document.getElementById('submitBtn').innerText = "Register";

    document.getElementById('btnRegister').classList.add('bg-gradient-to-r','from-[#0F1226]','to-purple-600','text-white');
    document.getElementById('btnLogin').classList.remove('bg-gradient-to-r','from-[#0F1226]','to-purple-600','text-white');

    document.getElementById('switchText').innerHTML =
        'Sudah punya akun? <span onclick="showLogin()" class="font-semibold text-black cursor-pointer">Login sekarang</span>';

    // 🔥 update URL
    if (push) {
        history.pushState({page: "register"}, "", "/register");
    }
}

/* ================= INIT DARI URL ================= */
window.onload = function () {
    const path = window.location.pathname;

    if (path.includes("register")) {
        showRegister(false);
    } else {
        showLogin(false);
    }
};

/* ================= HANDLE BACK BUTTON ================= */
window.onpopstate = function () {
    const path = window.location.pathname;

    if (path.includes("register")) {
        showRegister(false);
    } else {
        showLogin(false);
    }
};
</script>
</body>
</html>