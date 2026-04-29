<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengaturan Akun</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white flex items-center justify-center min-h-screen">

<!-- CONTAINER -->
<div class="
    w-full 
    max-w-sm md:max-w-xl 
    bg-white 
    rounded-3xl 
    shadow-md 
    p-5 md:p-8
">

        <!-- BACK BUTTON -->
           <div class="fixed top-4 left-4 z-50">
            <button onclick="goBack()" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-md">
                ←
            </button>
            </div>

    <!-- HEADER -->
    <div class="flex items-center gap-3 mb-6">
        <h1 class="font-semibold text-lg md:text-xl">Pengaturan Akun</h1>
    </div>

    <!-- FOTO -->
    <div class="flex flex-col items-center mb-6">
        <div class="w-24 h-24 md:w-28 md:h-28 rounded-xl overflow-hidden bg-white">
            <img src="{{ asset('avatar1.png') }}"class="w-full h-full object-cover">
        </div>

        <div class="mt-3 text-sm text-gray-600 font-medium">
            Lengkapi Profil anda
        </div>
    </div>

    <!-- FORM -->
    <div class="flex flex-col gap-4">

        <input type="text" placeholder="Konfirmasi Nama Anda"
            class="bg-gray-100 px-4 py-3 rounded-xl outline-none text-sm md:text-base text-gray-500 appearance-none w-full cursor-pointer">

        <input type="email" placeholder="Email"
            class="bg-gray-100 px-4 py-3 rounded-xl outline-none text-sm md:text-base text-gray-500 appearance-none w-full cursor-pointer">

        <input type="password" placeholder="Password"
            class="bg-gray-100 px-4 py-3 rounded-xl outline-none text-sm md:text-base text-gray-500 appearance-none w-full cursor-pointer">

            <div class=""mt-3 text-sm text-blue-600 font-medium">
            Lengkapi Data Kendaraan anda
            </div>
        <select class="bg-gray-100 px-4 py-3 rounded-xl outline-none text-sm md:text-base text-gray-500 appearance-none w-full cursor-pointer">
            <option value="" disabled selected>Jenis Kendaraan</option>
            <option value="motor">Motor</option>
            <option value="mobil">Mobil</option>
            <option value="truck">Truck</option>
            <option value="bus">Bus</option>
        </select>

        <input type="" placeholder="Plat Nomor Kendaraan"
            class="bg-gray-100 px-4 py-3 rounded-xl outline-none text-sm md:text-base text-gray-500 appearance-none w-full cursor-pointer">

    </div>

    <!-- BUTTON -->
    <div class="flex gap-3 mt-8">

<button onclick="resetForm()" class="
    flex-1 
    bg-gray-200 
    py-3 
    rounded-xl 
    text-sm md:text-base
">
    Cancel
</button>

        <button class="
            flex-1 
            bg-[#1C1F4A] 
            text-white 
            py-3 
            rounded-xl 
            text-sm md:text-base
        ">
            Save
        </button>

    </div>

</div>
<script>
function goBack() {
    if (document.referrer !== "") {
        window.history.back();
    } else {
        window.location.href = "/beranda";
    }
}

function openSidebar() {
    document.getElementById("sidebar").style.transform = "translateX(0)";
    document.getElementById("overlay").style.opacity = "1";
    document.getElementById("overlay").style.pointerEvents = "auto";
}

function closeSidebar() {
    document.getElementById("sidebar").style.transform = "translateX(100%)";
    document.getElementById("overlay").style.opacity = "0";
    document.getElementById("overlay").style.pointerEvents = "none";
}
function resetForm() {
    document.querySelectorAll('input').forEach(input => input.value = '');
    document.querySelector('select').value = '';
}
</script>

</body>
</html>